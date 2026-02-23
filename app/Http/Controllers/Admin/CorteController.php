<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OrdenVentaPago;
use App\Models\OrdenVenta;

class CorteController extends Controller
{
    public function index()
    {
        $cortes = OrdenVentaPago::with('orden.sucursal')
            ->latest()
            ->get()
            ->groupBy('orden_venta_id');

        return view('admin.cortes.index', compact('cortes'));
    }

    public function create()
    {
        $ordenes = OrdenVenta::where('estado', 'finalizada')
            ->whereDoesntHave('pagos')
            ->get();

        return view('admin.cortes.create', compact('ordenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'orden_venta_id' => 'required|exists:ordenes_venta,id',
            'efectivo'       => 'nullable|numeric|min:0',
            'tarjeta'        => 'nullable|numeric|min:0',
        ]);

        $orden = OrdenVenta::findOrFail($request->orden_venta_id);

        
        if ($orden->pagos()->exists()) {
            return back()->with('error', 'Esta orden ya tiene corte.');
        }

        $efectivo = (float) ($request->efectivo ?? 0);
        $tarjeta  = (float) ($request->tarjeta ?? 0);

        $totalOrden    = (float) $orden->total;
        $totalRecibido = $efectivo + $tarjeta;

        $diferencia = round($totalRecibido - $totalOrden, 2);

        if ($efectivo > 0) {
            $orden->pagos()->create([
                'metodo'     => 'efectivo',
                'monto'      => $efectivo,
                'diferencia' => $diferencia,
            ]);
        }

        if ($tarjeta > 0) {
            $orden->pagos()->create([
                'metodo'     => 'tarjeta',
                'monto'      => $tarjeta,
                'diferencia' => $diferencia,
            ]);
        }

        return redirect()
            ->route('admin.cortes.index')
            ->with('success', 'Corte registrado correctamente.');
    }

    public function show($ordenId)
    {
        $orden = OrdenVenta::with([
            'sucursal',
            'mermas',
            'gastos',
            'pagos'
        ])->findOrFail($ordenId);

        return view('admin.cortes.ticket', compact('orden'));
    }





}
