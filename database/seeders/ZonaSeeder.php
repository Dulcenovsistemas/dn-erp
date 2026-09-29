<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zona;

class ZonaSeeder extends Seeder
{
    public function run(): void
    {
        $zonas = [
            'CHIHUAHUA',
            'JUAREZ',
            'VICENTE GUERRERO',
            'MELGAR',
            'SUCURSAL 18',
            'RUBIO',
            'POLIFORO',
            'GUERRERO',
            'GOMEZ FARIAS',
            'MADEIRA',
            'DELICIAS',
            'MADERA',
            'TRES VIAS',
            'BENNY CTM',
            'RIO GRANDE',
            'SAN LORENZO',
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