<?php

namespace Database\Seeders;

use App\Models\Dia;
use Illuminate\Database\Seeder;


class DiaSeeder extends Seeder
{
    public function run(): void
    {
        $dias = [
            ['nombre' => 'Lunes', 'numero' => 1],
            ['nombre' => 'Martes', 'numero' => 2],
            ['nombre' => 'Miércoles', 'numero' => 3],
            ['nombre' => 'Jueves', 'numero' => 4],
            ['nombre' => 'Viernes', 'numero' => 5],
            ['nombre' => 'Sábado', 'numero' => 6],
            ['nombre' => 'Domingo', 'numero' => 7],
        ];

        foreach ($dias as $dia) {
            Dia::updateOrCreate(
                ['numero' => $dia['numero']],
                $dia
            );
        }
    }
}