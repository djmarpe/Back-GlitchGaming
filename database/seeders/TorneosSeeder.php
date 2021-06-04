<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\torneos;

class TorneosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        torneos::truncate();
        
        torneos::create([
            'idJuego' => 1,
            'diaFin' => 20,
            'mesFin' => 6,
            'anioFin' => 2021,
            'diaComienzo' => 20,
            'mesComienzo' => 6,
            'anioComienzo' => 2021,
            'equiposInscritos' => 4,
            'premio' => 150,
            'ultimo' => 1,
        ],);
        torneos::create([
            'idJuego' => 2,
            'diaFin' => 29,
            'mesFin' => 7,
            'anioFin' => 2021,
            'diaComienzo' => 30,
            'mesComienzo' => 7,
            'anioComienzo' => 2021,
            'equiposInscritos' => 15,
            'premio' => 2000,
            'ultimo' => 1,
        ],);
        torneos::create([
            'idJuego' => 3,
            'diaFin' => 13,
            'mesFin' => 8,
            'anioFin' => 2021,
            'diaComienzo' => 9,
            'mesComienzo' => 8,
            'anioComienzo' => 2021,
            'equiposInscritos' => 30,
            'premio' => 500,
            'ultimo' => 1,
        ],);
        torneos::create([
            'idJuego' => 4,
            'diaFin' => 10,
            'mesFin' => 9,
            'anioFin' => 2021,
            'diaComienzo' => 10,
            'mesComienzo' => 9,
            'anioComienzo' => 2021,
            'equiposInscritos' => 40,
            'premio' => 300,
            'ultimo' => 1,
        ],);
    }
}
