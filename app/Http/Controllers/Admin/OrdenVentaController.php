<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrdenVenta;
use App\Models\Sucursal;
use App\Models\ProductoVariante;
use App\Models\ProductoSucursal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;




class OrdenVentaController extends Controller
{
    /* ============================
     |  LISTADO
     ============================ */
    public function index()
    {
        $ordenes = OrdenVenta::with('sucursal')
            ->latest()
            ->paginate(20);

        return view('admin.ordenes.index', compact('ordenes'));
    }

    /* ============================
     |  FORM CREAR ORDEN
     ============================ */



    public function create()
    {
        $sucursales = Auth::user()
            ->sucursales()
            ->where('activo', 1)
            ->orderBy('nombre')
            ->get();

        return view('admin.ordenes.create', compact('sucursales'));
    }


    /* ============================
     |  CREAR ORDEN VACÍA
     ============================ */
    public function store(Request $request)
    {
        $request->validate([
            'sucursal_id' => 'required|exists:sucursals,id',
        ]);

        // 🔢 Generar folio incremental
        $ultimoId = OrdenVenta::max('id') ?? 0;
        $folio = 'OV-' . now()->format('Y') . '-' . str_pad($ultimoId + 1, 6, '0', STR_PAD_LEFT);

        $orden = OrdenVenta::create([
            'folio'       => $folio,
            'sucursal_id' => $request->sucursal_id,
            'fecha'       => now(),            // ✅ OBLIGATORIO
            'estado'      => 'en_proceso',         // ✅ nombre correcto
            'subtotal'    => 0,
            'descuento'   => 0,
            'total_mermas'=> 0,
            'total_gastos'=> 0,
            'total'       => 0,
            'notas'       => $request->notas,
        ]);

        return redirect()
            ->route('admin.ordenes.index', $orden)
            ->with('success', 'Orden de venta creada');
    }


    /* ============================
     |  EDITAR / RESUMEN
     ============================ */
    public function edit(OrdenVenta $orden)
    {
        if ($orden->estado === 'finalizada') {
            return redirect()
                ->route('admin.ordenes.show', $orden)
                ->with('error', 'No puedes editar una orden finalizada.');
        }


        $orden->load([
            'detalles.productoVariante.producto',
            'gastos',
            'mermas',
        ]);

        $variantes = ProductoVariante::with('producto')
            ->where('activo', 1)
            ->orderBy('producto_id')
            ->get();

        return view('admin.ordenes.pos', compact(
            'orden',
            'variantes'
        ));

    }

    /* ============================
     |  CAMBIAR ESTATUS
     ============================ */
    public function cambiarEstado(Request $request, OrdenVenta $orden)
    {
        $request->validate([
            'estado' => 'required|in:en_proceso,finalizada,cancelada',
        ]);

        if ($orden->estado === 'finalizada') {
            return back()->with('error', 'La orden ya está finalizada.');
        }

        DB::transaction(function () use ($orden, $request) {

            if ($request->estado === 'finalizada') {

                foreach ($orden->detalles as $detalle) {

                    $productoSucursal = ProductoSucursal::where('producto_variante_id', $detalle->producto_variante_id)
                        ->where('sucursal_id', $orden->sucursal_id)
                        ->first();


                    if (!$productoSucursal) {
                        throw new \Exception('No existe inventario para este producto en la sucursal.');
                    }

                    $productoSucursal->decrement('stock', $detalle->cantidad);
                }
            }

            $orden->update([
                'estado' => $request->estado
            ]);
        });

        return back()->with('success', 'Estado actualizado correctamente.');
    }


    /* ============================
     |  VISTA SOLO LECTURA
     ============================ */
    public function show(OrdenVenta $orden)
    {
        $orden->load([
            'sucursal',
            'detalles.productoVariante.producto',
            'mermas.productoVariante.producto',
            'gastos',
        ]);

        return view('admin.ordenes.ticket', compact('orden'));
    }


    public function destroy(OrdenVenta $orden)
    {
        $orden->delete();

        return redirect()
            ->route('admin.ordenes.index')
            ->with('success', 'Orden eliminada correctamente.');
    }

    public function pdf(OrdenVenta $orden)
    {
        $orden->load([
            'sucursal',
            'detalles.productoVariante.producto',
            'mermas.productoVariante.producto',
            'gastos',
        ]);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.ordenes.ticket-pdf', compact('orden'));
        $pdf->setPaper('letter');

        return $pdf->download('Orden-'.$orden->folio.'.pdf');
    }


    public function corte(OrdenVenta $orden)
    {
        if ($orden->estado !== 'finalizada') {
            return redirect()
                ->route('admin.ordenes.show', $orden)
                ->with('error', 'La orden debe estar finalizada.');
        }

        if ($orden->pagos()->exists()) {
            return redirect()
                ->route('admin.ordenes.show', $orden)
                ->with('error', 'El corte ya fue registrado.');
        }

        return view('admin.ordenes.corte', compact('orden'));
    }

   public function guardarCorte(Request $request, OrdenVenta $orden)
    {
        $request->validate([
            'efectivo' => 'nullable|numeric|min:0',
            'tarjeta'  => 'nullable|numeric|min:0',
        ]);

        $efectivo = (float) ($request->efectivo ?? 0);
        $tarjeta  = (float) ($request->tarjeta ?? 0);

        $totalOrden = (float) $orden->total;

        // 🚫 No permitir que exceda el total
        if (($efectivo + $tarjeta) > $totalOrden) {
            return back()->with('error', 'El monto ingresado excede el total de la orden.');
        }

        // 🚫 No permitir que quede menor
        if (($efectivo + $tarjeta) < $totalOrden) {
            return back()->with('error', 'El monto ingresado no cubre el total de la orden.');
        }

        // Guardar pagos
        if ($efectivo > 0) {
            $orden->pagos()->create([
                'metodo' => 'efectivo',
                'monto'  => $efectivo,
            ]);
        }

        if ($tarjeta > 0) {
            $orden->pagos()->create([
                'metodo' => 'tarjeta',
                'monto'  => $tarjeta,
            ]);
        }

        return redirect()
            ->route('admin.ordenes.show', $orden)
            ->with('success', 'Corte registrado correctamente.');
    }


   

}
