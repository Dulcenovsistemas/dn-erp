<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gasto extends Model
{
    protected $table = 'orden_venta_gastos';

    protected $fillable = [
        'orden_venta_id',
        'sucursal_id',
        'concepto',
        'monto',
        'imagen',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    /* ============================
     |  RELACIONES
     ============================ */

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenVenta::class, 'orden_venta_id');
    }

    public function sucursal(): BelongsTo
    {
        return $this->belongsTo(Sucursal::class);
    }

    /* ============================
     |  HOOKS
     ============================ */

    protected static function booted()
    {
        static::saved(function ($gasto) {
            $gasto->orden?->recalcularTotales();
        });

        static::deleted(function ($gasto) {
            $gasto->orden?->recalcularTotales();
        });
    }
}
