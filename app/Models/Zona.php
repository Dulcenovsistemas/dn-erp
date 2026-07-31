<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function sucursales()
    {
        return $this->hasMany(Sucursal::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}