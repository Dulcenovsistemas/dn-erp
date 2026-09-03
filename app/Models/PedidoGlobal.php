<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PedidoGlobal extends Model
{

    protected $table = 'pedidos_globales';

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'estatus',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function detalles(): HasMany
    {
        return $this->hasMany(PedidoGlobalDetalle::class);
    }
}