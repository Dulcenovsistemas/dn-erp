<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoSucursal extends Model
{
    protected $table = 'producto_sucursal';

    protected $fillable = [
        'sucursal_id',
        'producto_variante_id',
        'precio',
        'stock',
        'activo',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'activo' => 'boolean',
    ];

    /* =======================
     |  RELACIONES
     ======================= */

    public function variante()
    {
        return $this->belongsTo(ProductoVariante::class, 'producto_variante_id');
    }

    public function producto()
    {
        return $this->hasOneThrough(
            Producto::class,
            ProductoVariante::class,
            'id',          // FK en producto_variantes
            'id',          // FK en productos
            'producto_variante_id', // FK local
            'producto_id'  // FK en producto_variantes
        );
    }
}
