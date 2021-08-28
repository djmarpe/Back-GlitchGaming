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
            'diaNacimiento' => 18,
            'mesNacimiento' => 12,
            'anioNacimiento' => 1999,
            'email' => 'alejandro.martin.perez.99@gmail.com',
            'password' => 'Admin.1234',
            'nombreUsuario' => 'superadmin',
            'estado' => 1,
            'verificado' => 1,
            'descripcion' => 'Soy el Super administrador',
        ],);
        User::create([
            'nombre' => 'Bot',
            'apellidos' => 'Glitch',
            'diaNacimiento' => 3,
            'mesNacimiento' => 11,
            'anioNacimiento' => 2020,
            'email' => 'gliitchgaming.esports@gmail.com',
            'password' => 'Admin.1234',
            'nombreUsuario' => 'botglitch',
            'estado' => 1,
            'verificado' => 1,
            'descripcion' => 'Soy el Bot de pruebas',
        ],);
    }
}
