<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zona;

class ZonaSeeder extends Seeder
{
    public function run(): void
    {
        $zonas = [
            'Chihuahua',
            'Juarez',
            'Cuauhtemoc',
            'Zona Sur',
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