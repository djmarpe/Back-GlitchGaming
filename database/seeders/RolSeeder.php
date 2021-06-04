<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        rol::truncate();

        rol::create([
            'id' => 1,
            'descripcion' => 'Super Administrador',
                ],);
        rol::create([
            'id' => 2,
            'descripcion' => 'Administrador',
                ],);
        rol::create([
            'id' => 3,
            'descripcion' => 'Jugador',
                ],);
    }
}
