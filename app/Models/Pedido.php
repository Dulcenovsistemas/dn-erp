<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'folio',
        'sucursal_id',
        'user_id',
        'fecha_pedido',
        'fecha_entrega',
        'estatus',
        'observaciones',
    ];

    protected $casts = [
        'fecha_pedido' => 'date',
        'fecha_entrega' => 'date',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }

    public function historial()
    {
        return $this->hasMany(PedidoHistorial::class);
    }
}