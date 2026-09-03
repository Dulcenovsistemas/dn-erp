<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedidoGlobalDetalle extends Model
{
    protected $table = 'pedido_global_detalles';

    protected $fillable = [
        'pedido_global_id',
        'producto_id',
        'producto_variante_id',
        'cantidad',
    ];

    public function pedidoGlobal(): BelongsTo
    {
        return $this->belongsTo(PedidoGlobal::class);
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }

    public function productoVariante(): BelongsTo
    {
        return $this->belongsTo(ProductoVariante::class);
    }
}