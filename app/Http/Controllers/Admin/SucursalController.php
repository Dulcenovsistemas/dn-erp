<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
    public function index()
    {
        $sucursales = Sucursal::orderBy('nombre')->get();
        return view('admin.sucursales.index', compact('sucursales'));
    }

    


    public function create()
    {
        return view('admin.sucursales.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'direccion' => 'nullable|string',
        ]);

        // Manejo correcto del checkbox
        $data['activo'] = $request->has('activo');

        Sucursal::create($data);

        return redirect()
            ->route('admin.sucursales.index')
            ->with('success', 'Sucursal creada correctamente');
    }


    public function edit(Sucursal $sucursale)
    {
        return view('admin.sucursales.edit', ['sucursal' => $sucursale]);
    }

   public function update(Request $request, Sucursal $sucursale)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'direccion' => 'nullable|string',
        ]);

        // Manejo correcto del checkbox
        $data['activo'] = $request->has('activo');

        $sucursale->update($data);

        return redirect()
            ->route('admin.sucursales.index')
            ->with('success', 'Sucursal actualizada correctamente');
    }


    public function destroy(Sucursal $sucursale)
    {
        $sucursale->delete();

        return redirect()->route('admin.sucursales.index')
            ->with('success', 'Sucursal eliminada');
    }
}
