<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// ✅ IMPORTS OBLIGATORIOS
use App\Models\OrdenVenta;
use App\Models\ProductoSucursal;

class OrdenVentaDetalleController extends Controller
{
    public function store(Request $request, OrdenVenta $orden)
    {
        $request->validate([
            'producto_variante_id' => 'required|exists:producto_variantes,id',
            'cantidad' => 'required|numeric|min:1',
            'descuento' => 'nullable|numeric|min:0',
        ]);

        // 🔎 Obtener precio desde inventario de la sucursal
        $precio = ProductoSucursal::where('sucursal_id', $orden->sucursal_id)
            ->where('producto_variante_id', $request->producto_variante_id)
            ->value('precio');

        if ($precio === null) {
            return back()->withErrors('El producto no tiene precio asignado en esta sucursal');
        }

        $cantidad  = $request->cantidad;
        $descuento = $request->descuento ?? 0;

        $total = ($precio * $cantidad) - $descuento;

        // ➕ Crear detalle
        $orden->detalles()->create([
            'producto_variante_id' => $request->producto_variante_id,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'descuento' => $descuento,
            'total' => $total,
            'notas' => $request->notas,
        ]);

        // 🔁 Recalcular totales de la orden
        $orden->recalcularTotales();

        return back()->with('success', 'Producto agregado a la orden');
    }
}
