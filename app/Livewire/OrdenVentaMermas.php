<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\OrdenVenta;
use App\Models\OrdenVentaMerma;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class OrdenVentaMermas extends Component
{
    use WithFileUploads;

    public OrdenVenta $orden;

    /**
     * Mermas NUEVAS (captura)
     * [
     *   producto_variante_id => [
     *      [cantidad, tipo_merma, ...],
     *   ]
     * ]
     */
    public array $mermas = [];

    /**
     * Mermas GUARDADAS (solo lectura por ahora)
     */
    public array $mermasGuardadas = [];

    /* =========================
        MOUNT
    ========================= */
    public function mount(OrdenVenta $orden)
    {
        $this->orden = $orden;

        // Inicializar contenedores de mermas nuevas
        foreach ($orden->detalles as $detalle) {
            $this->mermas[$detalle->producto_variante_id] = [];
        }

        $this->cargarMermasGuardadas();
    }

    public function render()
    {
        return view('livewire.orden-venta-mermas');
    }

    /* =========================
        Cargar mermas guardadas
    ========================= */
    protected function cargarMermasGuardadas(): void
    {
        $this->orden->load('mermas.productoVariante.producto');

        $this->mermasGuardadas = $this->orden->mermas
            ->groupBy('producto_variante_id')
            ->map(fn ($grupo) => $grupo->map(fn ($merma) => [
                'id' => $merma->id,
                'cantidad' => $merma->cantidad,
                'tipo_merma' => $merma->tipo_merma,
                'origen_sucursal' => $merma->origen_sucursal,
                'lote' => $merma->lote,
                'monto' => $merma->monto,
                'imagen_path' => $merma->imagen_path,
                'observaciones' => $merma->observaciones,
            ])->toArray())
            ->toArray();
    }

    /* =========================
        Agregar / eliminar merma nueva
    ========================= */
    public function agregarMerma(int $productoVarianteId): void
    {
        $this->mermas[$productoVarianteId][] = [
            'cantidad' => null,
            'tipo_merma' => null,
            'origen_sucursal' => null,
            'lote' => null,
            'observaciones' => null,
            'imagen' => null,
        ];
    }

    public function eliminarMerma(int $productoVarianteId, int $index): void
    {
        unset($this->mermas[$productoVarianteId][$index]);
        $this->mermas[$productoVarianteId] = array_values($this->mermas[$productoVarianteId]);
        $this->resetErrorBag("mermas.$productoVarianteId");
    }

    /* =========================
        Total de mermas
    ========================= */
    public function getTotalMermasProperty()
    {
        return $this->orden->mermas->sum('monto');
    }


    public function actualizarMerma(int $productoVarianteId, int $index): void
    {
        $data = $this->mermasGuardadas[$productoVarianteId][$index] ?? null;

        if (!$data || empty($data['id'])) {
            return;
        }

        $merma = OrdenVentaMerma::find($data['id']);
        if (!$merma) return;

        // 🔍 Detalle de la orden
        $detalle = $this->orden->detalles
            ->where('producto_variante_id', $productoVarianteId)
            ->first();

        if (!$detalle) return;

        /** VALIDACIÓN: no exceder lo vendido */
        $otrasMermas = collect($this->mermasGuardadas[$productoVarianteId])
            ->where('id', '!=', $merma->id)
            ->sum('cantidad');

        $nuevoTotal = $otrasMermas + (int) $data['cantidad'];

        if ($nuevoTotal > $detalle->cantidad) {
            $this->addError(
                "mermasGuardadas.$productoVarianteId",
                "La edición excede lo vendido ({$detalle->cantidad})."
            );
            return;
        }

        // 💰 Recalcular monto
        $precio = (float) $detalle->precio_unitario;
        $monto = $precio * (int) $data['cantidad'];

        // 💾 UPDATE REAL
        $merma->update([
            'cantidad' => $data['cantidad'],
            'tipo_merma' => $data['tipo_merma'],
            'origen_sucursal' =>
                $data['tipo_merma'] === 'sucursal'
                    ? ($data['origen_sucursal'] ?? null)
                    : null,
            'lote' =>
                $data['tipo_merma'] === 'sucursal'
                    ? ($data['lote'] ?? null)
                    : null,
            'monto' => $monto,
            'observaciones' => $data['observaciones'] ?? null, // 👈 NUEVO
        ]);

        // 🔄 Sincronizar estado
        $this->orden->refresh();
        $this->cargarMermasGuardadas();

        $this->dispatch('merma-actualizada');
    }


    /* =========================
        Guardar mermas NUEVAS
    ========================= */
    public function guardarTodasLasMermas(): void
    {
        /** VALIDACIÓN: no exceder lo vendido */
        foreach ($this->mermas as $productoVarianteId => $lista) {

            $detalle = $this->orden->detalles
                ->where('producto_variante_id', $productoVarianteId)
                ->first();

            if (!$detalle) continue;

            $total = collect($lista)->sum(fn ($m) => (int) ($m['cantidad'] ?? 0));

            if ($total > $detalle->cantidad) {
                $this->addError(
                    "mermas.$productoVarianteId",
                    "Las mermas exceden lo vendido ({$detalle->cantidad})."
                );
                return;
            }
        }

        /** GUARDADO */
        foreach ($this->mermas as $productoVarianteId => $lista) {

            $detalle = $this->orden->detalles
                ->where('producto_variante_id', $productoVarianteId)
                ->first();

            if (!$detalle) continue;

            $precio = (float) $detalle->precio_unitario;

            foreach ($lista as $data) {

                if (empty($data['cantidad']) || empty($data['tipo_merma'])) continue;

                $imagenPath = null;
                if (
                    isset($data['imagen']) &&
                    $data['imagen'] instanceof TemporaryUploadedFile
                ) {
                    $imagenPath = $data['imagen']->store('mermas', 'public');
                }

                OrdenVentaMerma::create([
                    'orden_venta_id' => $this->orden->id,
                    'producto_variante_id' => $productoVarianteId,
                    'cantidad' => $data['cantidad'],
                    'monto' => $precio * (int) $data['cantidad'],
                    'tipo_merma' => $data['tipo_merma'],
                    'origen_sucursal' =>
                        $data['tipo_merma'] === 'sucursal'
                            ? ($data['origen_sucursal'] ?? null)
                            : null,
                    'lote' =>
                        $data['tipo_merma'] === 'sucursal'
                            ? ($data['lote'] ?? null)
                            : null,
                    'observaciones' => $data['observaciones']??null,
                    'imagen_path' => $imagenPath,
                ]);
            }
        }

        /** SINCRONIZAR ESTADO */
        $this->orden->refresh();
        $this->cargarMermasGuardadas();

        foreach ($this->mermas as $id => $v) {
            $this->mermas[$id] = [];
        }

        $this->dispatch('mermas-guardadas');
    }


    
}
