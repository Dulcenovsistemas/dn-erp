<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoMaximo extends Model
{
    protected $fillable = [
        'zona_id',
        'maximo',
    ];

    protected $casts = [
        'maximo' => 'integer',
    ];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
}