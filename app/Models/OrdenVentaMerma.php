<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenVentaMerma extends Model
{
    protected $fillable = [
        'orden_venta_id',
        'producto_variante_id',
        'cantidad',
        'monto',
        'tipo_merma',
        'origen_sucursal',
        'lote',
        'imagen_path',
        'observaciones',
    ];

    /* =========================
        Relaciones
    ========================= */

    public function ordenVenta()
    {
        return $this->belongsTo(OrdenVenta::class);
    }

    public function productoVariante()
    {
        return $this->belongsTo(ProductoVariante::class);
    }

   

}


