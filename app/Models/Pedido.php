<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'folio',
        'zona_id',
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

    public function zona()
    {
        return $this->belongsTo(Zona::class);
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