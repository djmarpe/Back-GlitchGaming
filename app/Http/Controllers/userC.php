<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\asignacionRol;
use App\Models\rol;

use Illuminate\Support\Facades\Mail;
use App\Mail\Preguntas;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class userC extends Controller {

    use AuthenticatesUsers;    
    
    public function login(Request $params) {
        
        $loginData = $params->validate([
            'nombreUsuario' => 'string|required',
            'password' => 'required'
        ]);
        
//        dd($loginData);
        
        if (!auth()->attempt($loginData)) {
            return response()->json(['message' => 'Login incorrecto. Revise las credenciales.'], 400);
        }
        
        $user = auth()->user();
        
        if ($user->verificado != 1) {
            return response()->json(['message' => 'Correo sin verificar'], 400);
        }
        
        if ($user->estado == 0) {
             return response()->json(['message' => 'Login incorrecto. Revise las credenciales.'], 400);
        }
        
        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        $rol = asignacionRol::with("roles", "users")
                ->where('idUsuario', $user->id)
                ->first();

        $return = [
            'id' => $user->id,
            'access_token' => $accessToken,
            'nombre' => $user->nombre,
            'apellidos' => $user->apellidos,
            'edad' => $user->edad,
            'email' => $user->email,
            'password' => $user->contra,
            'pais' => $user->pais,
            'nombreUsuario' => $user->nombreUsuario,
            'estado' => $user->estado,
            'verificado' => $user->verificado,
            'descripcion' => $user->descripcion,
            'rol' => $rol->roles->id
        ];
        
//        dd($return);
        
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
