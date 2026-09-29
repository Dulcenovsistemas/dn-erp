<?php

namespace App\Http\Controllers;

use App\Models\PedidoMaximo;
use App\Models\Zona;
use App\Models\Categoria;
use Illuminate\Http\Request;

class PedidoMaximoController extends Controller
{
    /**
     * Mostrar los máximos configurados.
     */

    public function index()
    {
        $zonas = Zona::orderBy('nombre')->get();

        $pedidosMaximos = PedidoMaximo::all();

        return view('pedidos.maximos.index', compact(
            'zonas',
            'pedidosMaximos'
        ));
    }



    /**
     * Mostrar formulario para crear un máximo.
     */
    public function create()
    {
        $zonas = Zona::where('activo', 1)
            ->orderBy('nombre')
            ->get();

        $categorias = Categoria::with([
            'productos' => function ($q) {
                $q->where('activo', 1)
                    ->orderBy('nombre');
            },
            'productos.variantes' => function ($q) {
                $q->where('activo', 1)
                    ->orderBy('nombre');
            },
        ])
        ->where('activo', 1)
        ->orderBy('nombre')
        ->get();

        return view('pedidos.maximos.create', compact(
            'zonas',
            'categorias'
        ));
    }

    /**
     * Guardar un máximo.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'zona_id' => 'required|exists:zonas,id',
            'maximo' => 'required|integer|min:0',
        ]);

        PedidoMaximo::updateOrCreate(
            [
                'zona_id' => $data['zona_id'],
            ],
            [
                'maximo' => $data['maximo'],
            ]
        );

        return redirect()
            ->route('admin.pedidos.maximos.index')
            ->with('success', 'Máximo de pedidos actualizado correctamente.');
    }

    /**
     * Mostrar formulario para editar.
     */
    public function edit(PedidoMaximo $pedidoMaximo)
    {
        $zonas = Zona::where('activo', 1)
            ->orderBy('nombre')
            ->get();

        $categorias = Categoria::with([
            'productos' => function ($q) {
                $q->where('activo', 1)
                    ->orderBy('nombre');
            },
            'productos.variantes' => function ($q) {
                $q->where('activo', 1)
                    ->orderBy('nombre');
            },
        ])
        ->where('activo', 1)
        ->orderBy('nombre')
        ->get();

        return view('pedidos.maximos.edit', compact(
            'pedidoMaximo',
            'zonas',
            'categorias'
        ));
    }

    /**
     * Actualizar un máximo.
     */
    public function update(Request $request, PedidoMaximo $pedidoMaximo)
    {
        $data = $request->validate([
            'zona_id' => 'required|exists:zonas,id',
            'producto_id' => 'required|exists:productos,id',
            'producto_variante_id' => 'required|exists:producto_variantes,id',
            'maximo' => 'required|integer|min:0',
        ]);

        $pedidoMaximo->update($data);

        return redirect()
            ->route('pedidos.maximos.index')
            ->with('success', 'Máximo actualizado correctamente.');
    }

    /**
     * Eliminar un máximo.
     */
    public function destroy(PedidoMaximo $pedidoMaximo)
    {
        $pedidoMaximo->delete();

        return redirect()
            ->route('pedidos.maximos.index')
            ->with('success', 'Máximo eliminado correctamente.');
    }
}