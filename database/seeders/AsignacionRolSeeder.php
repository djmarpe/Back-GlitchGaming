<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\asignacionRol;

class AsignacionRolSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        asignacionRol::truncate();

        asignacionRol::create([
            'idRol' => 1,
            'idUsuario' => 1,
                ],);
        asignacionRol::create([
            'idRol' => 1,
            'idUsuario' => 2,
                ],);
    }

}
