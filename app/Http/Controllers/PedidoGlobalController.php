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
/**
 * ============================================================
 * SHOW
 * ============================================================
 */
public function show(PedidoGlobal $pedidoGlobal)
{
    /*
     * ============================================================
     * FECHAS DEL PEDIDO GLOBAL
     * ============================================================
     */

    $inicioSemana = $pedidoGlobal->fecha_inicio
        ->copy()
        ->startOfDay();

    $finSemana = $pedidoGlobal->fecha_fin
        ->copy()
        ->endOfDay();


    /*
     * ============================================================
     * ZONAS
     * ============================================================
     */

    $zonas = \App\Models\Zona::orderBy('nombre')->get();


    /*
     * ============================================================
     * OBTENER PEDIDOS DE LA SEMANA
     * ============================================================
     */

    $pedidos = Pedido::with([
        'zona',
        'detalles.producto.categoria',
        'detalles.variante',
    ])
    ->where('estatus', 'enviado')
    ->whereDate(
        'fecha_entrega',
        '>=',
        $inicioSemana->toDateString()
    )
    ->whereDate(
        'fecha_entrega',
        '<=',
        $finSemana->toDateString()
    )
    ->get();


    /*
     * ============================================================
     * CONSTRUIR RESUMEN
     * ============================================================
     */

    $resumen = [];


    foreach ($pedidos as $pedido) {

        foreach ($pedido->detalles as $detalle) {

            $productoId = $detalle->producto_id;

            $varianteId = $detalle->producto_variante_id;

            $zonaId = $pedido->zona_id;


            /*
             * Clave única:
             *
             * producto + variante
             */

            $clave = $productoId . '-' . $varianteId;


            /*
             * Crear registro si todavía no existe
             */

            if (!isset($resumen[$clave])) {

                $resumen[$clave] = [

                    'categoria' =>
                        $detalle->producto->categoria->nombre,

                    'producto' =>
                        $detalle->producto->nombre,

                    'variante' =>
                        $detalle->variante->nombre,

                    'zonas' => [],

                    'total' => 0,

                ];
            }


            /*
             * Inicializar cantidad de la zona
             */

            if (!isset(
                $resumen[$clave]['zonas'][$zonaId]
            )) {

                $resumen[$clave]['zonas'][$zonaId] = 0;
            }


            /*
             * Sumar cantidad por zona
             */

            $resumen[$clave]['zonas'][$zonaId]
                += $detalle->cantidad;


            /*
             * Sumar total general
             */

            $resumen[$clave]['total']
                += $detalle->cantidad;
        }
    }


    /*
     * ============================================================
     * ORDENAR RESUMEN
     * ============================================================
     */

    $resumen = collect($resumen)
        ->sortBy([
            ['producto', 'asc'],
            ['variante', 'asc'],
        ])
        ->values();


    /*
     * ============================================================
     * ENVIAR DATOS A LA VISTA
     * ============================================================
     */

    return view(
        'pedidos.globales.show',
        compact(
            'pedidoGlobal',
            'resumen',
            'zonas',
            'inicioSemana',
            'finSemana'
        )
    );
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