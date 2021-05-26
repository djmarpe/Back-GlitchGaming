<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\asignacionRol;

class userC extends Controller {

    public function login(Request $params) {
        $usuario = User::where("nombreUsuario", $params->username)
                ->where("contra", $params->password)
                ->get();

        $usuario = json_decode($usuario[0]);


        $rol = asignacionRol::with("roles", "users")
                ->where('idUsuario', $usuario->id)
                ->first();

        $return = [
            'id' => $usuario->id,
            'nombre' => $usuario->nombre,
            'apellidos' => $usuario->apellidos,
            'edad' => $usuario->edad,
            'email' => $usuario->email,
            'contra' => $usuario->contra,
            'pais' => $usuario->pais,
            'nombreUsuario' => $usuario->nombreUsuario,
            'estado' => $usuario->estado,
            'verificado' => $usuario->verificado,
            'descripcion' => $usuario->descripcion,
            'rol' => $rol->roles->id
        ];
        return response()->json(($return), 200);
    }
    
    public function editEmail(Request $params) {
        //Hacemos una segunda validacion en el servidor
        $params->validate([
            'id' => 'required|integer',
            'email' => 'required|string',
        ]);
        
        $usuario = User::where("id",$params->id)->first();
        $usuario["email"] = $params->email;
        $usuario->save();
        return response()->json($usuario, 200);
    }

}
