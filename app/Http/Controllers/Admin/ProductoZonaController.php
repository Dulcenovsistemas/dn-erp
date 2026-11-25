<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Zona;
use Illuminate\Http\Request;

class ProductoZonaController extends Controller
{
    public function index(Request $request)
    {
        $zonas = Zona::orderBy('nombre')->get();

        $zonaSeleccionada = Zona::find($request->input('zona_id'))
            ?? $zonas->first();

        $productos = Producto::with('categoria')
            ->orderBy('nombre')
            ->get();

        $productosAsignados = $zonaSeleccionada
            ? $zonaSeleccionada->productos()
                ->pluck('productos.id')
                ->toArray()
            : [];

        return view('admin.productos-zona.index', compact(
            'zonas',
            'zonaSeleccionada',
            'productos',
            'productosAsignados'
        ));
    }

    public function update(Request $request, Zona $zona)
    {
        $datos = $request->validate([
            'producto_ids' => ['sometimes', 'array'],
            'producto_ids.*' => ['integer', 'exists:productos,id'],
        ]);

        // Si no se marcó ningún producto, se guarda una lista vacía.
        $zona->productos()->sync($datos['producto_ids'] ?? []);

        return redirect()
            ->route('admin.productos-zona.index', [
                'zona_id' => $zona->id,
            ])
            ->with('success', 'Productos de la zona actualizados correctamente.');
    }
}