<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MovimientoInventario;
use App\Models\ProductoSucursal;
use App\Models\ProductoVariante;
use App\Models\Sucursal;

class MovimientoInventarioController extends Controller
{
    public function index()
    {
        $movimientos = MovimientoInventario::with([
            'variante',
            'sucursalOrigen',
            'sucursalDestino'
        ])
        ->latest()
        ->paginate(20);

        return view('admin.movimientos.index', compact('movimientos'));
    }

    public function create()
    {
        $variantes = ProductoVariante::with('producto')->get();
        $sucursales = Sucursal::all();

        return view('admin.movimientos.create', compact('variantes', 'sucursales'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'producto_variante_id' => 'required|exists:producto_variantes,id',
            'tipo' => 'required|in:transferencia,entrada,salida',
            'cantidad' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {

            $this->procesarMovimiento($request);

        });

        return redirect()
            ->route('admin.movimientos.index')
            ->with('success', 'Movimiento registrado correctamente');
    }

    private function procesarMovimiento($request)
    {
        $tipo = $request->tipo;
        $cantidad = $request->cantidad;
        $varianteId = $request->producto_variante_id;
        $origenId = $request->sucursal_origen_id;
        $destinoId = $request->sucursal_destino_id;

        if ($tipo === 'transferencia') {

            if (!$origenId || !$destinoId) {
                throw new \Exception('Transferencia requiere origen y destino');
            }

            $this->transferencia($varianteId, $origenId, $destinoId, $cantidad);
        }

        if ($tipo === 'entrada') {

            if (!$destinoId) {
                throw new \Exception('Entrada requiere sucursal destino');
            }

            $this->entrada($varianteId, $destinoId, $cantidad);
        }

        if ($tipo === 'salida') {

            if (!$origenId) {
                throw new \Exception('Salida requiere sucursal origen');
            }

            $this->salida($varianteId, $origenId, $cantidad);
        }

        MovimientoInventario::create([
            'producto_variante_id' => $varianteId,
            'sucursal_origen_id' => $origenId,
            'sucursal_destino_id' => $destinoId,
            'tipo' => $tipo,
            'cantidad' => $cantidad,
            'referencia' => $request->referencia,
            'observaciones' => $request->observaciones,
        ]);
    }

    private function transferencia($varianteId, $origenId, $destinoId, $cantidad)
    {
        $origen = ProductoSucursal::where([
            'sucursal_id' => $origenId,
            'producto_variante_id' => $varianteId
        ])->lockForUpdate()->first();

        if (!$origen || $origen->stock < $cantidad) {
            throw new \Exception('Stock insuficiente en sucursal origen');
        }

        $origen->decrement('stock', $cantidad);

        $destino = ProductoSucursal::firstOrCreate(
            [
                'sucursal_id' => $destinoId,
                'producto_variante_id' => $varianteId
            ],
            [
                'precio' => $origen->precio,
                'stock' => 0
            ]
        );

        $destino->increment('stock', $cantidad);
    }

    private function entrada($varianteId, $destinoId, $cantidad)
    {
        $destino = ProductoSucursal::firstOrCreate(
            [
                'sucursal_id' => $destinoId,
                'producto_variante_id' => $varianteId
            ],
            [
                'precio' => 0,
                'stock' => 0
            ]
        );

        $destino->increment('stock', $cantidad);
    }

    private function salida($varianteId, $origenId, $cantidad)
    {
        $origen = ProductoSucursal::where([
            'sucursal_id' => $origenId,
            'producto_variante_id' => $varianteId
        ])->lockForUpdate()->first();

        if (!$origen || $origen->stock < $cantidad) {
            throw new \Exception('Stock insuficiente');
        }

        $origen->decrement('stock', $cantidad);
    }
}
