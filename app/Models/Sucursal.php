<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductoVariante;

class Sucursal extends Model
{
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'activo',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function productos()
    {
        return $this->belongsToMany(
            ProductoVariante::class,
            'producto_sucursal'
        )->withPivot('precio', 'stock', 'activo')
        ->withTimestamps();
    }

    public function inventario()
    {
        return $this->belongsToMany(
            ProductoVariante::class,
            'producto_sucursal',
            'sucursal_id',
            'producto_variante_id'
        )
        ->withPivot(['precio', 'stock', 'activo'])
        ->withTimestamps();
    }

}
