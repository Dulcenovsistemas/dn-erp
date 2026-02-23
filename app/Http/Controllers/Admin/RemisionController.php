<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Remision;
use App\Models\Sucursal;
use App\Models\ProductoVariante;
use App\Models\ProductoSucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use PHPUnit\TextUI\XmlConfiguration\RenameBeStrictAboutCoversAnnotationAttribute;
use Svg\Tag\Rect;

class RemisionController extends Controller
{
    public function index()
    {
        $remisiones = Remision::latest()->paginate(15);

        return view('admin.remisiones.index', compact('remisiones'));
    }

    public function create()
    {
        $sucursales = Auth::user()
            ->sucursales()
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get();

        return view('admin.remisiones.create', compact('sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sucursal_id' => 'required|exists:sucursals,id',
        ]);

        // 🔢 Generar folio incremental
        $ultimoId = Remision::max('id') ?? 0;
        $folio = 'REM-' . now()->format('Y') . '-' . str_pad($ultimoId + 1, 6, '0', STR_PAD_LEFT);

        $orden = Remision::create([
            'folio'       => $folio,
            'sucursal_id' => $request->sucursal_id,
            'fecha'       => now(),            // ✅ OBLIGATORIO
            'estado'      => 'en_proceso',         // ✅ nombre correcto
            'notas'       => $request->notas,
        ]);

        return redirect()
            ->route('admin.remisiones.index', $orden)
            ->with('success', 'Remisión creada');
    }


    public function destroy(Remision $remision)
    {
        $remision->delete();

        return redirect()
            ->route('admin.remisiones.index')
            ->with('success', 'Remision eliminada correctamente.');

        
    }

    public function edit(Remision $remision)
    {
        if ($remision->estado === 'finalizada') {
            return redirect()
                ->route('admin.ordenes.show', $remision)
                ->with('error', 'No puedes editar una orden finalizada.');
        }


        $remision->load([
            'detalles.productoVariante.producto',
        ]);

        $variantes = ProductoVariante::with('producto')
            ->where('activo', 1)
            ->orderBy('producto_id')
            ->get();

        return view('admin.remisiones.pos', compact(
            'remision',
            'variantes'
        ));
    }

    /* ============================
     |  CAMBIAR ESTATUS
     ============================ */
    public function cambiarEstado(Request $request, Remision $remision)
    {
        $request->validate([
            'estado' => 'required|in:en_proceso,finalizada,cancelada',
        ]);

        if ($remision->estado === 'finalizada') {
            return back()->with('error', 'La remisión ya está finalizada.');
        }

        DB::transaction(function () use ($remision, $request) {

            if ($request->estado === 'finalizada') {
             

                foreach ($remision->detalles as $detalle) {

                    $productoSucursal = ProductoSucursal::where('producto_variante_id', $detalle->producto_variante_id)
                        ->where('sucursal_id', $remision->sucursal_id)
                        ->first();

                    if (!$productoSucursal) {
                        throw new \Exception('No existe inventario para este producto en la sucursal.');
                    }

                    // 🔥 AQUÍ ES LA DIFERENCIA
                    $productoSucursal->increment('stock', $detalle->cantidad);
                }
            }

            $remision->update([
                'estado' => $request->estado
            ]);
        });

        return back()->with('success', 'Estado actualizado correctamente.');
    }



}
