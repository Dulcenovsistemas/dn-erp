<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoVariante extends Model
{
    protected $fillable = [
        'producto_id',
        'nombre',
        'sku',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function sucursales()
    {
        return $this->belongsToMany(
            Sucursal::class,
            'producto_sucursal',
            'producto_variante_id',
            'sucursal_id'
        )
        ->withPivot(['precio', 'stock', 'activo'])
        ->withTimestamps();
    }
}
