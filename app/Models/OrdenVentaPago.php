<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenVentaPago extends Model
{
    protected $table = 'orden_venta_pagos';

    protected $fillable = [
        'orden_venta_id',
        'metodo',
        'monto',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    /* ============================
     | RELACIONES
     ============================ */

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenVenta::class, 'orden_venta_id');
    }
}
