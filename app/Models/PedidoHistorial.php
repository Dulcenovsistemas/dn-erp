<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoHistorial extends Model
{
    protected $table = 'pedido_historial';

    protected $fillable = [
        'pedido_id',
        'user_id',
        'accion',
        'descripcion',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}