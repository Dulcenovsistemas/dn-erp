<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    protected $fillable = [
        'nombre',
        'numero',
    ];

    public function zonas()
    {
        return $this->belongsToMany(Zona::class, 'dia_zona');
    }
}