<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remision extends Model
{

    protected $table = 'remisiones';

    protected $fillable = [
        'folio',
        'planta_id',
        'sucursal_id',
        'estado',
        'fecha',
        'fecha_entrega',
        'notas',
        'created_by',
    ];


    public function detalles()
    {
        return $this->hasMany(RemisionDetalle::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    const STATUS_EN_PROCESO = 'en_proceso';
    const STATUS_FINALIZADA = 'finalizada';

    
    public function scopeEnProceso($query)
    {
        return $query->where('estado', self::STATUS_EN_PROCESO);
    }

    public function scopeFinalizadas($query)
    {
        return $query->where('estado', self::STATUS_FINALIZADA);
    }


    public function puedeEditar(): bool
    {
        return $this->estado === self::STATUS_EN_PROCESO;
    }



}
