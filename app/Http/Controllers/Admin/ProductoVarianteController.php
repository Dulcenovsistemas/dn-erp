<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\ProductoVariante;
use Illuminate\Http\Request;

class ProductoVarianteController extends Controller
{
    public function index(Producto $producto)
    {
        $variantes = $producto->variantes()->orderBy('nombre')->get();

        return view('admin.productos.variantes.index', compact('producto', 'variantes'));
    }

    public function create(Producto $producto)
    {
        return view('admin.productos.variantes.create', compact('producto'));
    }

    public function store(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
        ]);

        $data['activo'] = $request->has('activo');
        $data['producto_id'] = $producto->id;

        ProductoVariante::create($data);

        return redirect()
            ->route('admin.productos.variantes.index', $producto)
            ->with('success', 'Variante creada correctamente');
    }

    public function edit(Producto $producto, ProductoVariante $variante)
    {
        return view('admin.productos.variantes.edit', compact('producto', 'variante'));
    }

    public function update(Request $request, Producto $producto, ProductoVariante $variante)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'sku' => 'nullable|string|max:255',
        ]);

        $data['activo'] = $request->has('activo');

        $variante->update($data);

        return redirect()
            ->route('admin.productos.variantes.index', $producto)
            ->with('success', 'Variante actualizada correctamente');
    }

    public function destroy(Producto $producto, ProductoVariante $variante)
    {
        $variante->update([
            'activo' => false,
        ]);

        return redirect()
            ->route('admin.productos.variantes.index', $producto)
            ->with('success', 'Variante desactivada correctamente');
    }
}
