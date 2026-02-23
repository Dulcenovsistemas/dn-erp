<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use App\Models\ProductoVariante;
use Illuminate\Http\Request;

class InventarioController extends Controller
{

    public function index(Sucursal $sucursal)
    {
        $variantes = ProductoVariante::with(['producto.categoria'])
            ->where('activo', 1)
            ->get();

        $inventario = $sucursal->inventario
            ->keyBy('id'); // id de producto_variante

        return view('admin.inventario.index', compact(
            'sucursal',
            'variantes',
            'inventario'
        ));
    }
    
    public function edit(Sucursal $sucursal)
    {
        $variantes = ProductoVariante::with('producto.categoria')
            ->where('activo', true)
            ->orderBy('producto_id')
            ->get();

        // 👇 CAMBIO CLAVE AQUÍ
        $inventario = $sucursal->inventario()
            ->get()
            ->keyBy('id');

        return view(
            'admin.inventario.edit',
            compact('sucursal', 'variantes', 'inventario')
        );
    }


    public function update(Request $request, Sucursal $sucursal)
    {
        if (!$request->has('variantes')) {
            return back();
        }

        foreach ($request->variantes as $varianteId => $data) {
            $sucursal->inventario()->syncWithoutDetaching([
                $varianteId => [
                    'precio' => $data['precio'] ?? 0,
                    'stock'  => $data['stock'] ?? 0,
                    'activo' => isset($data['activo']),
                ],
            ]);
        }

        return redirect()
            ->route('admin.sucursales.index')
            ->with('success', 'Inventario actualizado correctamente');
    }
}
