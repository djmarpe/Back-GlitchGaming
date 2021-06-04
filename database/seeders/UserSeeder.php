<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        
        User::create([
            'nombre' => 'Alejandro',
            'apellidos' => 'Martín Pérez',
            'edad' => 21,
            'email' => 'alejandro.martin.perez.99@gmail.com',
            'password' => 'Admin.1234',
            'pais' => 'España',
            'nombreUsuario' => 'djmarpe',
            'estado' => 1,
            'verificado' => 1,
            'descripcion' => 'Soy el Super administrador',
        ],);
        User::create([
            'nombre' => 'Glitch',
            'apellidos' => 'Gaming',
            'edad' => 10,
            'email' => 'info@glitchgaming.es',
            'password' => 'Admin.1234',
            'pais' => 'España',
            'nombreUsuario' => 'gg',
            'estado' => 1,
            'verificado' => 1,
            'descripcion' => 'Soy el bot de pruebas',
        ],);
    }
}
