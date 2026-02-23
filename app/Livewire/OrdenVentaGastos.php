<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\OrdenVenta;
use App\Models\OrdenVentaGasto;
use Illuminate\Support\Facades\Storage;

class OrdenVentaGastos extends Component
{
    use WithFileUploads;



    public $concepto = '';
    public $monto = '';
    public $comprobante;

    public OrdenVenta $orden;
    public $gastos = [];

    protected $rules = [
        'concepto' => 'required|string|max:255',
        'monto' => 'required|numeric|min:0.01',
        'comprobante' => 'required|image|max:2048',
    ];

   public function mount(OrdenVenta $orden)
    {
        $this->orden = $orden;
        $this->cargarGastos();
    }


    public function guardarGasto()
    {
        $this->validate();

        $path = $this->comprobante->store('gastos', 'public');

        OrdenVentaGasto::create([
            'orden_venta_id' => $this->orden->id,
            'concepto' => $this->concepto,
            'monto' => $this->monto,
            'comprobante_path' => $path,
        ]);

        $this->orden->recalcularTotales();

        // limpiar inputs
        $this->reset(['concepto', 'monto', 'comprobante']);

        // 🔥 ESTO ES LO QUE TE FALTABA
        $this->cargarGastos();

        $this->dispatch('gasto-guardado');
    }


   public function eliminarGasto($gastoId)
    {
        $gasto = OrdenVentaGasto::findOrFail($gastoId);

        Storage::disk('public')->delete($gasto->comprobante_path);
        $gasto->delete();

        $this->orden->recalcularTotales();

        // 🔥 refrescar listado
        $this->cargarGastos();
    }


    public function render()
    {
        return view('livewire.orden-venta-gasto');
    }

    public function cargarGastos()
    {
        $this->gastos = $this->orden
            ->gastos()
            ->orderBy('created_at', 'desc')
            ->get();
    }


}
