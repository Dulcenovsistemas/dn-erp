<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoSucursal;

class PosRemision extends Component
{
    public $remision;
    public $search = '';
    public $items = []; // indexados por producto_sucursal_id

  

    /* =======================
     |  MOUNT
     ======================= */
    public function mount($remision)
    {
        $this->remision = $remision;

        // Cargar productos ya existentes en la orden
        foreach ($remision->detalles as $detalle) {

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
        $query = ProductoSucursal::query()
            ->join('producto_variantes', 'producto_variantes.id', '=', 'producto_sucursal.producto_variante_id')
            ->join('productos', 'productos.id', '=', 'producto_variantes.producto_id')
            ->where('producto_sucursal.sucursal_id', $this->remision->sucursal_id)
            ->where('producto_sucursal.activo', 1)
            ->where('producto_sucursal.precio', '>', 0)
            ->select('producto_sucursal.*')
            ->with(['variante.producto'])
            ->orderBy('productos.nombre');

        // 🔎 Si hay búsqueda, filtrar
        if (strlen($this->search) >= 1) {
            $query->where('productos.nombre', 'like', '%' . $this->search . '%');
        }

        return $query->limit(20)->get();
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
            $this->items[$productoSucursalId]['cantidad']++;
            return;
        }

        // Agregar nuevo producto SIN validar stock
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
     |  GUARDAR ORDEN
     ======================= */
   public function guardarRemision()
{
    DB::transaction(function () {

        // Solo borrar detalles anteriores
        $this->remision->detalles()->delete();

        // Guardar nuevos detalles
        foreach ($this->items as $item) {

            $this->remision->detalles()->create([
                'producto_variante_id' => $item['producto_variante'],
                'cantidad'             => $item['cantidad'],
            ]);
        }

    });

    $this->dispatch('remision-registrada');
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

 


    public function render()
    {
        return view('livewire.pos-remision-ingreso');
    }


    


}
