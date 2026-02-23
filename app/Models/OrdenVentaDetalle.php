<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenVentaDetalle extends Model
{
    protected $table = 'orden_venta_detalles';

    protected $fillable = [
        'orden_venta_id',
        'producto_variante_id',
        'producto_nombre',
        'variante_nombre',
        'precio_unitario',
        'cantidad',
        'descuento',
        'total',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'descuento' => 'decimal:2',
        'total' => 'decimal:2',
        'cantidad' => 'integer',
    ];

    /* ============================
     |  RELACIONES
     ============================ */

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenVenta::class, 'orden_venta_id');
    }

    public function variante(): BelongsTo
    {
        return $this->belongsTo(ProductoVariante::class, 'producto_variante_id');
    }

    /* ============================
     |  LÓGICA DE NEGOCIO
     ============================ */

    public function calcularTotal(): void
    {
        $subtotal = $this->precio_unitario * $this->cantidad;

        $this->total = max(
            $subtotal - ($this->descuento ?? 0),
            0
        );
    }

    protected static function booted()
    {
        static::saving(function ($detalle) {
            $detalle->calcularTotal();
        });

        static::saved(function ($detalle) {
            $detalle->orden?->recalcularTotales();
        });

        static::deleted(function ($detalle) {
            $detalle->orden?->recalcularTotales();
        });
    }

    public function productoVariante(): BelongsTo
    {
        return $this->belongsTo(ProductoVariante::class);
    }
}
