<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdenVentaGasto extends Model
{
    protected $table = 'orden_venta_gastos';

    protected $fillable = [
        'orden_venta_id',
        'concepto',
        'monto',
        'comprobante_path',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
    ];

    public function orden(): BelongsTo
    {
        return $this->belongsTo(OrdenVenta::class, 'orden_venta_id');
    }
}
