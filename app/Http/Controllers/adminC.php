<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\asignacionRol;
use App\Models\rol;
use Illuminate\Support\Facades\Mail;
use App\Mail\Preguntas;
use App\Mail\Verificar;
use App\Mail\Baja;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class adminC extends Controller {

    public function getUsers() {
        $listaUsuarios = User::all();
        return response()->json([
                    'listaUsuarios' => ($listaUsuarios)
                        ], 200);
    }

    public function deleteUser(Request $params) {

        Mail::to($params->email)->send(new Baja());

        if (!Mail::failures()) {

            User::where("id", $params->id)->update([
                "estado" => 0
            ]);

            asignacionRol::where("idUsuario", $params->id)->delete();

            return response()->json([
                        'borrado' => ('OK')
                            ], 200);
        } else {
            return response()->json(null, 405);
        }
    }

    public function newUser(Request $params) {
        $params->validate([
            'nombre' => 'string|required',
            'apellidos' => 'string|required',
            'diaNacimiento' => 'required',
            'mesNacimiento' => 'required',
            'anioNacimiento' => 'required',
            'email' => 'string|required',
            'nombreUsuario' => 'string|required',
            'password' => 'string|required',
            'rol' => 'required'
        ]);

        $user = new User([
            'nombre' => $params->nombre,
            'apellidos' => $params->apellidos,
            'diaNacimiento' => $params->diaNacimiento,
            'mesNacimiento' => $params->mesNacimiento,
            'anioNacimiento' => $params->anioNacimiento,
            'email' => $params->email,
            'password' => bcrypt($params->password),
            'nombreUsuario' => $params->nombreUsuario,
            'estado' => 0,
            'verificado' => 0,
            'descripcion' => '',
        ]);

        $codigo = $this->generarAlfanumerico(0, 15);
        $user->remember_token = $codigo;

        $url = $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] != 80 ? $_SERVER['SERVER_PORT'] : '') . DIRECTORY_SEPARATOR . "EjerciciosPHP2020" . DIRECTORY_SEPARATOR . "Back-GlitchGaming" . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "api" . DIRECTORY_SEPARATOR . "verify" . DIRECTORY_SEPARATOR . $codigo;

        Mail::to($user->email)->send(new Verificar($user->nombreUsuario, $url));

        if (!Mail::failures()) {
            $user->estado = 1;
            $user->save();
            switch ($params->rol['name']) {
                case "Super Administrador":
                    asignacionRol::create([
                        'idRol' => 1,
                        'idUsuario' => $user->id
                    ]);
                    return response()->json([
                                'message' => 'Creacion satisfactoria, verifique su email.',
                                'code' => '201'
                                    ], 201);
                    break;
                
                case "Administrador":
                    asignacionRol::create([
                        'idRol' => 2,
                        'idUsuario' => $user->id
                    ]);
                    return response()->json([
                                'message' => 'Creacion satisfactoria, verifique su email.',
                                'code' => '201'
                                    ], 201);
                    break;
                case "Jugador":
                    asignacionRol::create([
                        'idRol' => 3,
                        'idUsuario' => $user->id
                    ]);
                    return response()->json([
                                'message' => 'Creacion satisfactoria, verifique su email.',
                                'code' => '201'
                                    ], 201);
                    break;
            }
        } else {
            return response()->json([
                        'message' => 'Error del sistema'
                            ], 500);
        }
    }
    
    public function generarAlfanumerico($val1, $val2) {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = substr(str_shuffle($permitted_chars), $val1, $val2);

        return $string;
    }

}
