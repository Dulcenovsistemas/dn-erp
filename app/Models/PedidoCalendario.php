<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoCalendario extends Model
{
    protected $table = 'pedido_calendario';

    protected $fillable = [
        'sucursal_id',
        'dia_pedido',
        'dias_entrega',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }
}