<?php

namespace App\Http\Controllers;

use App\Models\PedidoGlobal;
use App\Models\PedidoGlobalDetalle;
use App\Models\PedidoDetalle;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoGlobalController extends Controller
{
    /**
     * ============================================================
     * INDEX
     * ============================================================
     */
    public function index()
    {
        $pedidosGlobales = PedidoGlobal::with('detalles')
            ->orderByDesc('fecha_inicio')
            ->orderByDesc('id')
            ->get();

        return view(
            'pedidos.globales.index',
            compact('pedidosGlobales')
        );
    }

    /**
     * ============================================================
     * GENERAR PEDIDO GLOBAL
     * ============================================================
     */
    public function generar(Request $request)
{
    $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ]);

    DB::transaction(function () use ($request) {

        $pedidoGlobal = PedidoGlobal::create([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'estatus' => 'abierto',
        ]);

        $detalles = PedidoDetalle::whereBetween('fecha', [
            $request->fecha_inicio,
            $request->fecha_fin
        ])
        ->select(
            'producto_id',
            'producto_variante_id',
            DB::raw('SUM(cantidad) as cantidad')
        )
        ->groupBy(
            'producto_id',
            'producto_variante_id'
        )
        ->get();

        foreach ($detalles as $detalle) {

            PedidoGlobalDetalle::create([
                'pedido_global_id' => $pedidoGlobal->id,
                'producto_id' => $detalle->producto_id,
                'producto_variante_id' => $detalle->producto_variante_id,
                'cantidad' => $detalle->cantidad,
            ]);
        }
    });

    return redirect()
    ->route('admin.pedidos.globales.index')
    ->with(
        'success',
        'Pedido global generado correctamente.'
    );
}


    /**
     * ============================================================
     * SHOW
     * ============================================================
     */
    
  
    public function show(Request $request, PedidoGlobal $pedidoGlobal)
    {
        // Filtro de semana
        $pedidoGlobalId = $request->query('pedido_global_id');

        if ($pedidoGlobalId) {
            $semanaSeleccionada = PedidoGlobal::find($pedidoGlobalId);

            if ($semanaSeleccionada) {
                $pedidoGlobal = $semanaSeleccionada;
            }
        }

        // Fechas de la semana seleccionada
        $inicioSemana = $pedidoGlobal->fecha_inicio->copy()->startOfDay();
        $finSemana = $pedidoGlobal->fecha_fin->copy()->endOfDay();

        // Semanas disponibles
        $semanasDisponibles = PedidoGlobal::orderByDesc('fecha_inicio')->get();

        // Zonas disponibles para el filtro
        $zonasDisponibles = \App\Models\Zona::orderBy('nombre')->get();

        // Filtro de zona: todas por defecto
        $zonaSeleccionada = $request->query('zona_id', 'todas');

        // Obtener pedidos enviados de la semana
        $consulta = Pedido::with([
            'zona',
            'detalles.producto.categoria',
            'detalles.variante',
        ])
            ->where('estatus', 'enviado')
            ->whereBetween('fecha_entrega', [
                $inicioSemana,
                $finSemana,
            ]);

        // Aplicar filtro de zona
        if ($zonaSeleccionada !== 'todas' && $zonaSeleccionada !== '') {
            $consulta->where('zona_id', $zonaSeleccionada);
        }

        $pedidos = $consulta->get();
      

        /*
        |--------------------------------------------------------------------------
        | Consolidar por producto y variante
        |--------------------------------------------------------------------------
        | Se suman las cantidades de las zonas incluidas en la consulta.
        */

        
        $resumen = collect();

        foreach ($pedidos as $pedido) {
            foreach ($pedido->detalles as $detalle) {

                if (!$detalle->producto || !$detalle->variante) {
                    continue;
                }

                $productoId = $detalle->producto_id;
                $varianteId = $detalle->producto_variante_id;
                $clave = $productoId;


              
              
               // Normalizar el nombre de la variante
                $nombreOriginal = mb_strtoupper(
                    trim($detalle->variante->nombre ?? ''),
                    'UTF-8'
                );

                $nombreOriginal = preg_replace('/\s+/u', ' ', $nombreOriginal);
                $nombreOriginal = trim($nombreOriginal);

                // Detectar el tamaño usando el nombre original
                if ($nombreOriginal === 'CHICO') {
                    $nombreVariante = 'CHICO';

                } elseif ($nombreOriginal === 'GRANDE') {
                    $nombreVariante = 'GRANDE';

                } elseif (str_contains($nombreOriginal, 'UNIC')) {
                    $nombreVariante = 'TAMAÑO ÚNICO';

                } else {
                    $nombreVariante = null;
                }
                // Crear fila del producto si aún no existe
                if (!$resumen->has($clave)) {
                    $resumen->put($clave, [
                        'producto_id' => $productoId,
                        'categoria' => $detalle->producto->categoria->nombre
                            ?? 'Sin categoría',
                        'producto' => $detalle->producto->nombre,
                        'variantes' => [
                            'CHICO' => 0,
                            'GRANDE' => 0,
                            'TAMAÑO ÚNICO' => 0,
                        ],
                        'total' => 0,
                    ]);
                }


                    if (str_contains($nombreOriginal, 'UNIC')) {
                        logger()->info('Tamaño único detectado', [
                            'original' => $nombreOriginal,
                            'asignado' => $nombreVariante,
                            'cantidad' => $detalle->cantidad,
                        ]);
                    }

                // Acumular cantidad en la variante correspondiente

               
                $fila = $resumen->get($clave);
                $cantidad = (int) $detalle->cantidad;

                if ($nombreVariante !== null) {
                    $fila['variantes'][$nombreVariante] += $cantidad;
                }

                $fila['total'] += $cantidad;

                $resumen->put($clave, $fila);
            }
        }

        // Ordenar por categoría y producto
        $resumen = $resumen
            ->sortBy([
                ['categoria', 'asc'],
                ['producto', 'asc'],
            ])
            ->values();


        // Calcular totales generales
        $totalGeneral = $resumen->sum('total');

        $totalMinis = $resumen
            ->filter(function ($fila) {
                return str_contains(
                    mb_strtoupper($fila['categoria']),
                    'MINIS Y PANQUES'
                );
            })
            ->sum('total');

        $totalSinMinis = $totalGeneral - $totalMinis;

        // Totales por variante, excluyendo minis y panqués
        $totalPorVariante = [
            'CHICO' => 0,
            'GRANDE' => 0,
            'TAMAÑO ÚNICO' => 0,
        ];

        foreach ($resumen as $fila) {
            if (str_contains(
                mb_strtoupper($fila['categoria']),
                'MINIS Y PANQUES'
            )) {
                continue;
            }

            foreach ($totalPorVariante as $variante => $total) {
                $totalPorVariante[$variante] +=
                    $fila['variantes'][$variante] ?? 0;
            }
        }

        return view('pedidos.globales.show', compact(
            'pedidoGlobal',
            'resumen',
            'zonasDisponibles',
            'semanasDisponibles',
            'zonaSeleccionada',
            'inicioSemana',
            'finSemana',
            'totalGeneral',
            'totalMinis',
            'totalSinMinis',
            'totalPorVariante'
        ));
    }

    /**
     * ============================================================
     * EDIT
     * ============================================================
     */
    public function edit(PedidoGlobal $pedidoGlobal)
    {
        $pedidoGlobal->load([
            'detalles.producto',
            'detalles.productoVariante',
        ]);

        return view(
            'pedidos.globales.edit',
            compact('pedidoGlobal')
        );
    }


    /**
     * ============================================================
     * UPDATE
     * ============================================================
     */
    public function update(
        Request $request,
        PedidoGlobal $pedidoGlobal
    ) {

        $data = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'estatus' => 'required|string',
            'detalles' => 'nullable|array',
            'detalles.*.cantidad' => 'required|integer|min:0',
        ]);


        DB::transaction(function () use (
            $request,
            $pedidoGlobal,
            $data
        ) {

            /*
             * Actualizar encabezado
             */
            $pedidoGlobal->update([
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_fin' => $data['fecha_fin'],
                'estatus' => $data['estatus'],
            ]);


            /*
             * Actualizar cantidades
             */
            if ($request->has('detalles')) {

                foreach ($request->detalles as $detalleId => $detalle) {

                    $pedidoGlobalDetalle =
                        PedidoGlobalDetalle::where('id', $detalleId)
                            ->where(
                                'pedido_global_id',
                                $pedidoGlobal->id
                            )
                            ->first();

                    if (!$pedidoGlobalDetalle) {
                        continue;
                    }


                    /*
                     * Si la cantidad queda en 0,
                     * eliminamos el detalle.
                     */
                    if ((int) $detalle['cantidad'] === 0) {

                        $pedidoGlobalDetalle->delete();

                        continue;
                    }


                    $pedidoGlobalDetalle->update([
                        'cantidad' => $detalle['cantidad'],
                    ]);
                }
            }
        });


        return redirect()
            ->route(
                'admin.pedidos.globales.show',
                $pedidoGlobal
            )
            ->with(
                'success',
                'Pedido global actualizado correctamente.'
            );
    }


    /**
     * ============================================================
     * DESTROY
     * ============================================================
     */
    public function destroy(PedidoGlobal $pedidoGlobal)
    {
        DB::transaction(function () use ($pedidoGlobal) {

            /*
             * Primero eliminamos los detalles.
             */
            PedidoGlobalDetalle::where(
                'pedido_global_id',
                $pedidoGlobal->id
            )->delete();


            /*
             * Después eliminamos el pedido global.
             */
            $pedidoGlobal->delete();
        });


        return redirect()
    ->route('admin.pedidos.globales.index')
    ->with(
        'success',
        'Pedido global eliminado correctamente.'
    );
    }
}