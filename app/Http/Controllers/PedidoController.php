<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categoria;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pedido;
use App\Models\PedidoDetalle;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with(['zona', 'usuario'])
            ->latest()
            ->paginate(20);

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

            // El índice 0 del formulario corresponde al jueves
            $fecha = Carbon::now()->startOfWeek(Carbon::THURSDAY);

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
            'detalles.producto',
            'detalles.variante',
        ]);

        return view('pedidos.show', compact('pedido'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
