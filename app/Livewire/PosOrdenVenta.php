<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoSucursal;

class PosOrdenVenta extends Component
{
    public $orden;
    public $search = '';
    public $items = []; // indexados por producto_sucursal_id

    protected $listeners = [
        'guardar-orden' => 'guardarOrden',
    ];

    /* =======================
     |  MOUNT
     ======================= */
    public function mount($orden)
    {
        $this->orden = $orden;

        // Cargar productos ya existentes en la orden
        foreach ($orden->detalles as $detalle) {

            $productoSucursal = ProductoSucursal::with(['variante.producto'])
                ->where('producto_variante_id', $detalle->producto_variante_id)
                ->where('sucursal_id', $this->orden->sucursal_id)
                ->first();

            if (!$productoSucursal) {
                continue;
            }

            $this->items[$productoSucursal->id] = [
                'id'                => $productoSucursal->id, // producto_sucursal_id
                'producto_variante' => $detalle->producto_variante_id,
                'nombre'            => $productoSucursal->variante->producto->nombre,
                'precio'            => (float) $detalle->precio_unitario,
                'cantidad'          => (int) $detalle->cantidad,
                'descuento'         => (float) ($detalle->descuento ?? 0),
                'descuento_tipo'    => 'monto',
            ];
        }
    }

    /* =======================
     |  BUSCADOR
     ======================= */
    public function getProductosFiltradosProperty()
{
    if (strlen($this->search) < 2) {
        return collect();
    }

    return ProductoSucursal::query()
        ->join('producto_variantes', 'producto_variantes.id', '=', 'producto_sucursal.producto_variante_id')
        ->join('productos', 'productos.id', '=', 'producto_variantes.producto_id')
        ->where('producto_sucursal.sucursal_id', $this->orden->sucursal_id)
        ->where('producto_sucursal.activo', 1)
        ->where('producto_sucursal.precio', '>', 0)
        ->where('producto_sucursal.stock', '>', 0)
        ->where('productos.nombre', 'like', '%' . $this->search . '%')
        ->select('producto_sucursal.*')
        ->with(['variante.producto'])
        ->limit(8)
        ->get();
}


    public function seleccionarProducto($productoSucursalId)
    {
        $this->search = ''; // cerrar dropdown antes
        $this->agregarProducto($productoSucursalId);
    }

    /* =======================
     |  AGREGAR / QUITAR
     ======================= */
    public function agregarProducto($productoSucursalId)
    {
        $productoSucursal = ProductoSucursal::find($productoSucursalId);
        if (!$productoSucursal) return;

        // Si ya existe en el carrito
        if (isset($this->items[$productoSucursalId])) {

            if ($this->items[$productoSucursalId]['cantidad'] >= $productoSucursal->stock) {
                return; // No permitir exceder stock
            }

            $this->items[$productoSucursalId]['cantidad']++;
            return;
        }

        // Si es nuevo producto
        if ($productoSucursal->stock <= 0) {
            return;
        }

        $this->items[$productoSucursalId] = [
            'id'                => $productoSucursalId,
            'producto_variante' => $productoSucursal->producto_variante_id,
            'nombre'            => $productoSucursal->variante->producto->nombre,
            'precio'            => (float) $productoSucursal->precio,
            'cantidad'          => 1,
            'descuento'         => 0,
            'descuento_tipo'    => 'monto',
        ];
    }


    public function incrementar($productoSucursalId)
    {
        if (!isset($this->items[$productoSucursalId])) return;

        $productoSucursal = ProductoSucursal::find($productoSucursalId);
        if (!$productoSucursal) return;

        if ($this->items[$productoSucursalId]['cantidad'] >= $productoSucursal->stock) {
            return;
        }

        $this->items[$productoSucursalId]['cantidad']++;
    }

    public function decrementar($productoSucursalId)
    {
        if (!isset($this->items[$productoSucursalId])) return;

        $this->items[$productoSucursalId]['cantidad']--;

        if ($this->items[$productoSucursalId]['cantidad'] <= 0) {
            unset($this->items[$productoSucursalId]);
        }
    }

    public function quitarProducto($productoSucursalId)
    {
        unset($this->items[$productoSucursalId]);
    }

    /* =======================
     |  TOTALES
     ======================= */
    public function getSubtotalProperty()
    {
        return collect($this->items)->sum(fn ($item) =>
            (float) $item['precio'] * (int) $item['cantidad']
        );
    }

    public function getTotalDescuentosProperty()
    {
        return collect($this->items)->sum(fn ($item) =>
            (float) ($item['descuento'] ?? 0)
        );
    }

    public function getTotalProperty()
    {
        return max(
            (float) $this->subtotal
            - (float) $this->totalDescuentos
            - (float) $this->totalMermas
            - (float) $this->totalGastos,
            0
        );
    }


   public function getTotalItem($item)
{
    return max(
        (float) $item['precio'] * (int) $item['cantidad'],
        0
    );
}


    /* =======================
     |  GUARDAR ORDEN
     ======================= */
    public function guardarOrden()
    {
        DB::transaction(function () {

            $this->orden->detalles()->delete();

            foreach ($this->items as $item) {
                $this->orden->detalles()->create([
                    'producto_variante_id' => $item['producto_variante'],
                    'cantidad'             => $item['cantidad'],
                    'precio_unitario'      => $item['precio'],
                    'descuento'            => $item['descuento'] ?? 0,
                    'total'                => $this->getTotalItem($item),
                ]);
            }

            $this->orden->update([
                'descuento' => (float) $this->totalDescuentos,
            ]);

            $this->orden->recalcularTotales();

        });

        $this->dispatch('venta-registrada');
    }

    /* =======================
     |  OTROS
     ======================= */
    public function updatedItems()
    {
        foreach ($this->items as &$item) {
            $item['descuento'] = (float) ($item['descuento'] ?? 0);
        }
    }

    public function irAMermas()
    {
        return redirect()->route(
            'admin.ordenes.mermas.index',
            $this->orden->id
        );
    }

    public function irAGastos()
    {
        return redirect()->route(
            'admin.ordenes.gastos.index',
            $this->orden->id
        );
    }


    public function render()
    {
        return view('livewire.pos-orden-venta');
    }


    public function getTotalMermasProperty()
    {
        return (float) $this->orden->mermas()
            ->selectRaw('SUM(cantidad * monto) as total')
            ->value('total') ?? 0;
    }


    public function getTotalGastosProperty()
    {
        return (float) $this->orden->gastos()
            ->sum('monto') ?? 0;
    }


}
