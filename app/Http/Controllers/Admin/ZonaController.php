<?php

namespace App\Http\Controllers\Admin;



use App\Models\Zona;
use App\Models\Dia;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $zonas = Zona::with('dias')
            ->orderBy('nombre')
            ->paginate(15);

        return view('admin.zonas.index', compact('zonas'));
    }

    public function create()
    {
        $dias = Dia::orderBy('numero')->get();

        return view('admin.zonas.create', compact('dias'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                'unique:zonas,nombre',
            ],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['required', 'boolean'],
            'dias' => ['required', 'array', 'min:1'],
            'dias.*' => ['required', 'integer', 'distinct', 'exists:dias,id'],
        ]);

        DB::transaction(function () use ($datos) {
            $zona = Zona::create([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'] ?? null,
                'activo' => $datos['activo'],
            ]);

            $zona->dias()->sync($datos['dias']);
        });

        return redirect()
            ->route('admin.zonas.index')
            ->with('success', 'Zona creada correctamente.');
    }

    public function show(Zona $zona)
    {
        return redirect()->route('admin.zonas.edit', $zona);
    }

    public function edit(Zona $zona)
    {
        $zona->load('dias');
        $dias = Dia::orderBy('numero')->get();

        return view('admin.zonas.edit', compact('zona', 'dias'));
    }

    public function update(Request $request, Zona $zona)
    {
        $datos = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('zonas', 'nombre')->ignore($zona->id),
            ],
            'descripcion' => ['nullable', 'string'],
            'activo' => ['required', 'boolean'],
            'dias' => ['required', 'array', 'min:1'],
            'dias.*' => ['required', 'integer', 'distinct', 'exists:dias,id'],
        ]);

        DB::transaction(function () use ($datos, $zona) {
            $zona->update([
                'nombre' => $datos['nombre'],
                'descripcion' => $datos['descripcion'] ?? null,
                'activo' => $datos['activo'],
            ]);

            $zona->dias()->sync($datos['dias']);
        });

        return redirect()
            ->route('admin.zonas.index')
            ->with('success', 'Zona actualizada correctamente.');
    }

    public function destroy(Zona $zona)
    {
        // Evitar borrar zonas que tienen historial o relaciones.
        if (
            $zona->pedidos()->exists() ||
            $zona->sucursales()->exists() ||
            $zona->users()->exists()
        ) {
            return redirect()
                ->route('admin.zonas.index')
                ->with('error', 'No se puede eliminar esta zona porque tiene pedidos, sucursales o usuarios relacionados. Puedes desactivarla.');
        }

        $zona->delete();

        return redirect()
            ->route('admin.zonas.index')
            ->with('success', 'Zona eliminada correctamente.');
    }
}
