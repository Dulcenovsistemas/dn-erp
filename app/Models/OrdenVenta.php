<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenVenta extends Model
{

    


    protected $table = 'ordenes_venta';

    protected $fillable = [
        'folio',
        'planta_id',
        'sucursal_id',
        'estado',
        'fecha',
        'fecha_entrega',
        'subtotal',
        'descuento',
        'total_gastos',
        'total_mermas',
        'total',
        'notas',
        'created_by',
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'fecha_entrega' => 'date',
        'subtotal' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total_gastos' => 'decimal:2',
        'total_mermas' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /* ============================
     |  RELACIONES
     ============================ */

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(OrdenVentaDetalle::class);
    }

    public function gastos(): HasMany
    {
        return $this->hasMany(Gasto::class);
    }

    public function mermas(): HasMany
    {
        return $this->hasMany(OrdenVentaMerma::class);
    }

    public function pagos()
    {
        return $this->hasMany(OrdenVentaPago::class);
    }


    /* ============================
     |  SCOPES
     ============================ */

    const STATUS_EN_PROCESO = 'en_proceso';
    const STATUS_FINALIZADA = 'finalizada';

    public function scopeEnProceso($query)
    {
        return $query->where('estado', self::STATUS_EN_PROCESO);
    }

    public function scopeFinalizadas($query)
    {
        return $query->where('estado', self::STATUS_FINALIZADA);
    }


    /* ============================
     |  MÉTODOS DE CÁLCULO
     ============================ */

    public function recalcularTotales(): void
    {
        $subtotal = $this->detalles()
            ->selectRaw('SUM(precio_unitario * cantidad) as total')
            ->value('total') ?? 0;

        $totalGastos = $this->gastos()->sum('monto');

        $totalMermas = (float) $this->mermas()
            ->selectRaw('SUM(cantidad * monto) as total')
            ->value('total') ?? 0;

        $this->update([
            'subtotal'      => $subtotal,
            'total_gastos'  => $totalGastos,
            'total_mermas'  => $totalMermas,
            'total' => max(
                ($subtotal - $this->descuento - $totalMermas - $totalGastos),
                0
            ),
        ]);
    }



    /* ============================
     |  HELPERS
     ============================ */

    public function puedeEditar(): bool
    {
        return $this->estado === self::STATUS_EN_PROCESO;
    }




}
