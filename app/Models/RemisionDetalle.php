<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemisionDetalle extends Model
{
    protected $table = 'remision_detalles';

    protected $fillable = [
        'remision_id',
        'producto_variante_id',
        'producto_nombre',
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

    public function remision(): BelongsTo
    {
        return $this->belongsTo(Remision::class, 'remision_id');
    }


    public function variante(): BelongsTo
    {
        return $this->belongsTo(ProductoVariante::class, 'producto_variante_id');
    }


    public function productoVariante(): BelongsTo
    {
        return $this->belongsTo(ProductoVariante::class);
    }
}
