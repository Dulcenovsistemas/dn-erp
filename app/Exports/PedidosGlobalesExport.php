<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PedidosGlobalesExport implements WithMultipleSheets
{
    protected $datos;

    public function __construct(array $datos)
    {
        $this->datos = $datos;
    }

    public function sheets(): array
    {
        $datos = $this->datos;

        $hojas = [];

        // Primera hoja: resumen semanal
        $hojas[] = new ResumenSemanalSheet($datos);

        // Siete hojas: desglose por día
        foreach ($datos['diasSemana'] as $dia) {
            $hojas[] = new DiaSheet(
                $dia,
                $datos['zonaNombre']
            );
        }

        return $hojas;
    }
}