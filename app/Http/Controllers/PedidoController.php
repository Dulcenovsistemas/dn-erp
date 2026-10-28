<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categoria;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use App\Models\PedidoGlobal;


use App\Exports\PedidoExport;
use Maatwebsite\Excel\Facades\Excel;

class PedidoController extends Controller
{
    
    
/**
 * Comprueba si el pedido pertenece a un periodo global procesado.
 */
    
    private function estaBloqueadoPorGlobal(Pedido $pedido): bool
    {
        $fechaEntrega = Carbon::parse($pedido->fecha_entrega)
            ->startOfDay();

        return PedidoGlobal::where('estatus', 'procesado')
            ->get(['fecha_inicio', 'fecha_fin'])
            ->contains(function ($global) use ($fechaEntrega) {
                $inicio = Carbon::parse($global->fecha_inicio)
                    ->startOfDay();

                // Bloquear hasta el lunes siguiente al final del periodo.
                $fin = Carbon::parse($global->fecha_fin)
                    ->next(Carbon::MONDAY)
                    ->startOfDay();

                return $fechaEntrega->greaterThanOrEqualTo($inicio)
                    && $fechaEntrega->lessThanOrEqualTo($fin);
            });
    }

    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = auth()->user();

        $consulta = Pedido::with(['zona', 'usuario']);

        // El administrador puede consultar todos los pedidos.
        if (!$usuario->hasRole('admin')) {

            // Los demás usuarios solo ven pedidos de sus zonas asignadas.
            $zonasIds = $usuario->zonas()->pluck('zonas.id');

            $consulta->whereIn('zona_id', $zonasIds);
        }

        $pedidos = $consulta
            ->latest()
            ->paginate(20);


        
        
        $globalesProcesados = PedidoGlobal::where('estatus', 'procesado')
            ->get(['fecha_inicio', 'fecha_fin']);

        $pedidos->getCollection()->transform(function ($pedido) use ($globalesProcesados) {
            $fechaEntrega = Carbon::parse($pedido->fecha_entrega)->startOfDay();

            $pedido->bloqueado_por_global = $globalesProcesados->contains(
                function ($global) use ($fechaEntrega) {
                    $inicio = Carbon::parse($global->fecha_inicio)->startOfDay();

                    $fin = Carbon::parse($global->fecha_fin)
                        ->next(Carbon::MONDAY)
                        ->startOfDay();

                    return $fechaEntrega->greaterThanOrEqualTo($inicio)
                        && $fechaEntrega->lessThanOrEqualTo($fin);
                }
            );

            return $pedido;
        });


        return view('pedidos.index', compact('pedidos'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::with(['productos' => function ($q) {
            $q->where('activo', 1)->orderBy('nombre');
        }])->where('activo',1)->get();

        return view('pedidos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'zona_id' => 'required|exists:zonas,id',
            'pedido' => 'required|array',
            'observaciones' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request) {

            $estatus = $request->accion === 'borrador'
                ? 'borrador'
                : 'enviado';

            $pedido = Pedido::create([
                'folio'            => $this->generarFolio(),
                'zona_id'          => $request->zona_id,
                'user_id'          => Auth::id(),
                'fecha_pedido'     => now(),
                'fecha_entrega'    => Carbon::now()->next(Carbon::MONDAY),
                'estatus'          => $estatus,
                'observaciones'    => $request->observaciones,
            ]);

            // La fecha base es el lunes de la semana de entrega
            $fecha = Carbon::now()->next(Carbon::MONDAY);

            foreach ($request->pedido as $dia => $productos) {

                $fechaDia = $fecha->copy()->addDays($dia);

                foreach ($productos as $productoId => $presentaciones) {

                    foreach ($presentaciones as $varianteId => $cantidad) {

                        $cantidad = (int) $cantidad;

                        if ($cantidad <= 0) {
                            continue;
                        }

                        PedidoDetalle::create([
                            'pedido_id'            => $pedido->id,
                            'producto_id'          => $productoId,
                            'producto_variante_id' => $varianteId,
                            'fecha'                => $fechaDia->toDateString(),
                            'cantidad'             => $cantidad,
                        ]);
                    }
                }
            }



        });

        return redirect()
            ->route('admin.pedidos.index')
            ->with('success', 'Pedido guardado correctamente.');
    }

    private function generarFolio(): string
    {
        $ultimo = Pedido::max('id') + 1;

        return 'PED-' . str_pad($ultimo, 6, '0', STR_PAD_LEFT);
    }


    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        $pedido->load([
            'zona',
            'usuario',
            'detalles',
            'detalles.producto',
            'detalles.variante',
        ]);

        $categorias = Categoria::with([
            'productos' => function ($q) {
                $q->where('activo', 1)
                    ->orderBy('nombre');
            },
            'productos.variantes'
        ])
        ->where('activo', 1)
        ->orderBy('nombre')
        ->get();

        return view('pedidos.show', compact(
            'pedido',
            'categorias'
        ));
    }

    public function globales()
    {
        $pedidosGlobales = PedidoGlobal::orderBy('fecha_inicio', 'desc')
            ->get();

        return view('pedidos.globales.index', compact('pedidosGlobales'));
    }

    
        public function globalesShow(Request $request, PedidoGlobal $pedidoGlobal)
        {
            // Permitir cambiar de semana desde el filtro.
            if ($request->filled('pedido_global_id')) {
                $pedidoGlobal = PedidoGlobal::findOrFail(
                    $request->input('pedido_global_id')
                );
            }

            $inicioSemana = $pedidoGlobal->fecha_inicio->copy()->startOfDay();
            $finSemana = $pedidoGlobal->fecha_fin->copy()->endOfDay();

            // Todas las zonas disponibles para el selector.
            $zonasDisponibles = \App\Models\Zona::orderBy('nombre')->get();

            // Filtro de zona: "todas" o un ID específico.
            $zonaSeleccionada = $request->input('zona_id', 'todas');

            // Si se eligió una zona, la tabla solo mostrará esa zona.
            $zonas = $zonaSeleccionada === 'todas'
                ? $zonasDisponibles
                : $zonasDisponibles
                    ->where('id', (int) $zonaSeleccionada)
                    ->values();

            // Semanas disponibles para el selector.
            $semanasDisponibles = PedidoGlobal::orderByDesc('fecha_inicio')
                ->get();

            // Pedidos enviados de la semana seleccionada.
            $consulta = Pedido::with([
                'zona',
                'detalles.producto.categoria',
                'detalles.variante',
            ])
                ->where('estatus', 'enviado')
                ->whereDate('fecha_entrega', '>=', $inicioSemana->toDateString())
                ->whereDate('fecha_entrega', '<=', $finSemana->toDateString());

            // Aplicar el filtro antes de sumar las cantidades.
            if ($zonaSeleccionada !== 'todas') {
                $consulta->where('zona_id', (int) $zonaSeleccionada);
            }

            $pedidos = $consulta->get();

            $resumen = [];

            foreach ($pedidos as $pedido) {
                foreach ($pedido->detalles as $detalle) {

                    // Evitar errores si algún producto o categoría ya no existe.
                    if (!$detalle->producto || !$detalle->producto->categoria) {
                        continue;
                    }

                    $productoId = $detalle->producto_id;
                    $varianteId = $detalle->producto_variante_id;
                    $zonaId = $pedido->zona_id;

                    $clave = $productoId . '-' . $varianteId;

                    if (!isset($resumen[$clave])) {
                        $resumen[$clave] = [
                            'categoria' => $detalle->producto->categoria->nombre,
                            'producto' => $detalle->producto->nombre,
                            'variante' => $detalle->variante->nombre ?? 'ÚNICO',
                            'zonas' => [],
                            'total' => 0,
                        ];
                    }

                    if (!isset($resumen[$clave]['zonas'][$zonaId])) {
                        $resumen[$clave]['zonas'][$zonaId] = 0;
                    }

                    $resumen[$clave]['zonas'][$zonaId] += $detalle->cantidad;
                    $resumen[$clave]['total'] += $detalle->cantidad;
                }
            }

            // Ordenar por número de categoría, producto y variante.
            $resumen = collect($resumen)
                ->sortBy(function ($fila) {
                    preg_match('/^(\d+)/', trim($fila['categoria'] ?? ''), $coincidencia);

                    $numeroCategoria = isset($coincidencia[1])
                        ? (int) $coincidencia[1]
                        : 9999;

                    return sprintf(
                        '%04d|%s|%s',
                        $numeroCategoria,
                        mb_strtoupper($fila['producto'] ?? ''),
                        mb_strtoupper($fila['variante'] ?? '')
                    );
                })
                ->values();

            // Totales de la selección actual.
            $totalGeneral = $resumen->sum('total');

            $totalMinis = $resumen
                ->filter(function ($fila) {
                    return str_contains(
                        strtoupper(trim($fila['categoria'] ?? '')),
                        'MINIS Y PANQUES'
                    );
                })
                ->sum('total');

            $totalSinMinis = $totalGeneral - $totalMinis;

            return view('pedidos.globales.show', compact(
                'pedidoGlobal',
                'resumen',
                'zonas',
                'zonasDisponibles',
                'semanasDisponibles',
                'zonaSeleccionada',
                'inicioSemana',
                'finSemana',
                'totalGeneral',
                'totalMinis',
                'totalSinMinis'
            ));
        }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {

        
        if ($this->estaBloqueadoPorGlobal($pedido)) {
            return redirect()
                ->route('admin.pedidos.show', $pedido)
                ->with('error', 'Este pedido está bloqueado porque su pedido global ya fue procesado.');
        }


        $pedido->load([
            'zona',
            'detalles',
            'detalles.producto',
            'detalles.variante',
        ]);

        $categorias = Categoria::with([
            'productos' => function ($q) {
                $q->where('activo', 1)
                ->orderBy('nombre');
            },
            'productos.variantes'
        ])
        ->where('activo', 1)
        ->orderBy('nombre')
        ->get();

        return view('pedidos.edit', compact(
            'pedido',
            'categorias'
        ));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {

        
        if ($this->estaBloqueadoPorGlobal($pedido)) {
            return redirect()
                ->route('admin.pedidos.show', $pedido)
                ->with('error', 'No puedes modificar un pedido cuyo periodo global ya fue procesado.');
        }


        $request->validate([
            'zona_id' => 'required|exists:zonas,id',
            'pedido' => 'required|array',
            'observaciones' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $pedido) {

            /*
            * ==========================================
            * ACTUALIZAR DATOS GENERALES
            * ==========================================
            */

            $pedido->update([
                'zona_id' => $request->zona_id,
                'observaciones' => $request->observaciones,
                'estatus' => $request->accion === 'borrador'
                    ? 'borrador'
                    : 'enviado',
            ]);


            /*
            * ==========================================
            * ELIMINAR DETALLES ANTERIORES
            * ==========================================
            *
            * Como vamos a guardar nuevamente todo el pedido,
            * eliminamos los detalles anteriores.
            */

            $pedido->detalles()->delete();


            /*
            * ==========================================
            * FECHA INICIAL
            * ==========================================
            *
            * fecha_entrega corresponde al lunes
            * de la semana del pedido.
            */

            $fecha = Carbon::parse(
                $pedido->fecha_entrega
            )->startOfDay();


            /*
            * ==========================================
            * GUARDAR NUEVOS DETALLES
            * ==========================================
            */

            foreach ($request->pedido as $dia => $productos) {

                $fechaDia = $fecha
                    ->copy()
                    ->addDays((int) $dia);


                foreach ($productos as $productoId => $presentaciones) {

                    foreach ($presentaciones as $varianteId => $cantidad) {

                        $cantidad = (int) $cantidad;


                        /*
                        * No guardamos cantidades en cero.
                        */

                        if ($cantidad <= 0) {
                            continue;
                        }


                        PedidoDetalle::create([
                            'pedido_id'            => $pedido->id,
                            'producto_id'          => $productoId,
                            'producto_variante_id' => $varianteId,
                            'fecha'                => $fechaDia->toDateString(),
                            'cantidad'             => $cantidad,
                        ]);

                    }

                }

            }

        });


        /*
        * ==========================================
        * REGRESAR AL PEDIDO
        * ==========================================
        */

        return redirect()
            ->route('admin.pedidos.show', $pedido)
            ->with(
                'success',
                'Pedido actualizado correctamente.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {

        
        if ($this->estaBloqueadoPorGlobal($pedido)) {
            return redirect()
                ->route('admin.pedidos.show', $pedido)
                ->with('error', 'No puedes eliminar un pedido cuyo periodo global ya fue procesado.');
        }


        DB::transaction(function () use ($pedido) {

            // Eliminar los detalles del pedido
            $pedido->detalles()->delete();

            // Eliminar el pedido
            $pedido->delete();
        });

        return redirect()
            ->route('admin.pedidos.index')
            ->with('success', 'Pedido eliminado correctamente.');
    }


    public function anterior($zona)
    {
        $pedido = Pedido::with([
            'detalles'
        ])
        ->where('zona_id', $zona)
        ->orderByDesc('fecha_entrega')
        ->orderByDesc('id')
        ->first();

        if (!$pedido) {
            return response()->json([
                'encontrado' => false,
                'mensaje' => 'No existe un pedido anterior para esta zona.'
            ]);
        }

        $detalles = $pedido->detalles->map(function ($detalle) {

            return [
                'fecha' => $detalle->fecha,
                'producto_id' => $detalle->producto_id,
                'producto_variante_id' => $detalle->producto_variante_id,
                'cantidad' => $detalle->cantidad,
            ];

        });

        return response()->json([
            'encontrado' => true,
            'pedido_id' => $pedido->id,
            'fecha_entrega' => $pedido->fecha_entrega,
            'detalles' => $detalles,
        ]);
    }


    public function exportarExcel(Pedido $pedido)
    {
        $usuario = auth()->user();

        // Respetar el acceso por zona de cada usuario.
        if (!$usuario->hasRole('admin')) {
            $tieneAcceso = $usuario->zonas()
                ->where('zonas.id', $pedido->zona_id)
                ->exists();

            abort_unless($tieneAcceso, 403);
        }

        return Excel::download(
            new PedidoExport($pedido),
            'Pedido-' . $pedido->folio . '.xlsx'
        );
    }
}
