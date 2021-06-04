<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\juego;

class JuegoSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        juego::truncate();

        juego::create([
            'id' => 1,
            'juego' => 'League of Legends',
                ],);
        juego::create([
            'id' => 2,
            'juego' => 'Valorant',
                ],);
        juego::create([
            'id' => 3,
            'juego' => 'Call of Duty',
                ],);
        juego::create([
            'id' => 4,
            'juego' => 'FIFA 21',
                ],);
        juego::create([
            'id' => 5,
            'juego' => 'Forza Horizon 4',
                ],);
    }

}
