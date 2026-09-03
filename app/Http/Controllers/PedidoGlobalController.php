<?php

namespace App\Http\Controllers;

use App\Models\PedidoGlobal;
use App\Models\PedidoGlobalDetalle;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoGlobalController extends Controller
{
    public function generar(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        DB::transaction(function () use ($request) {

            // Crear el pedido global
            $pedidoGlobal = PedidoGlobal::create([
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'estatus' => 'abierto',
            ]);

            // Obtener y agrupar los detalles de los pedidos
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

            // Crear los detalles del pedido global
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
            ->back()
            ->with('success', 'Pedido global generado correctamente.');
    }
}