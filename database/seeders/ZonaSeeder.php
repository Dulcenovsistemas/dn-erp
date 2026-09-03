<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zona;

class ZonaSeeder extends Seeder
{
    public function run(): void
    {
        $zonas = [
            'CUU Renato',
            'JUA Renato',
            'Cuauhtemoc',
            'Delicias',
            'Parral',
            'Camargo',
            'Meoqui',
        ];

        foreach ($zonas as $nombre) {

            Zona::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'descripcion' => null,
                    'activo' => true,
                ]
            );

        }
    }
}