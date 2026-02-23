<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Merma extends Model
{
    protected $table = 'orden_venta_mermas';

    protected $fillable = [
        'orden_venta_id',
        'sucursal_id',
        'producto_variante_id',
        'tipo',              // transporte | sucursal
        'origen',            // fabrica | sucursal (solo si tipo = sucursal)
        'lote',
        'cantidad',
        'monto',
        'imagen',
    ];

    protected $casts = [
        'cantidad' => 'integer',
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

    public function variante(): BelongsTo
    {
        return $this->belongsTo(ProductoVariante::class, 'producto_variante_id');
    }

    /* ============================
     |  HELPERS
     ============================ */

    public function esTransporte(): bool
    {
        return $this->tipo === 'transporte';
    }

    public function esSucursal(): bool
    {
        return $this->tipo === 'sucursal';
    }

    /* ============================
     |  HOOKS
     ============================ */

    protected static function booted()
    {
        static::saved(function ($merma) {
            $merma->orden?->recalcularTotales();
        });

        static::deleted(function ($merma) {
            $merma->orden?->recalcularTotales();
        });
    }
}
