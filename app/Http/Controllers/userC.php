<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\asignacionRol;
use Illuminate\Support\Facades\Mail;
use App\Mail\Preguntas;

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

        $usuario = User::where("id", $params->id)->first();
        $usuario["email"] = $params->email;
        $usuario->save();
        return response()->json($usuario, 200);
    }

    public function editUsername(Request $params) {
        //Hacemos una segunda validacion en el servidor
        $params->validate([
            'id' => 'required|integer',
            'username' => 'required|string',
        ]);

        $usuario = User::where("id", $params->id)->first();
        $usuario["nombreUsuario"] = $params->username;
        $usuario->save();
        return response()->json($usuario, 200);
    }

    public function editPassword(Request $params) {
        //Hacemos una segunda validacion en el servidor
        $params->validate([
            'id' => 'required|integer',
            'password' => 'required|string',
        ]);

        $usuario = User::where("id", $params->id)->first();
        $usuario["contra"] = $params->password;
        $usuario->save();
        return response()->json($usuario, 200);
    }

    public function editDescription(Request $params) {
        //Hacemos una segunda validacion en el servidor
        $params->validate([
            'id' => 'required|integer',
            'password' => 'string',
        ]);

        $usuario = User::where("id", $params->id)->first();
        $usuario["descripcion"] = $params->description;
        $usuario->save();
        return response()->json($usuario, 200);
    }

    public function enviarMail(Request $params) {
        // Hacemos una segunda validación de los campos
        $params->validate([
            'de' => 'required|string',
            'asunto' => 'required|string',
            'mensaje' => 'required|string',
            'nombre' => 'required|string',
        ]);
        
        // Creamos el correo que vamos a enviar
        $correo = new Preguntas($params->all());
        
        // Mandamos el correo a la dirección que queramos        
        Mail::to('gliitchgaming.esports@gmail.com')->send($correo);

        if (!Mail::failures()) {
            // Si el mail se ha enviado devolvemos 200
            return response()->json([
                        'message' => 'Correo enviado'
                            ], 200);
        } else {
            // Si no ha podido enviarse devolvemos 500
            return response()->json([
                        'message' => 'Error del sistema'
                            ], 500);
        }
    }

}
