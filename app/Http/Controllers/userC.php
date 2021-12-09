<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\asignacionRol;
use App\Models\rol;
use Illuminate\Support\Facades\Mail;
use App\Mail\Preguntas;
use App\Mail\Verificar;
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
            'password' => $user->password,
            'nombreUsuario' => $user->nombreUsuario,
            'estado' => $user->estado,
            'verificado' => $user->verificado,
            'descripcion' => $user->descripcion,
            'valorant' => $user->valorant,
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

    public function editValorant(Request $params) {
        //Hacemos una segunda validacion en el servidor
        $params->validate([
            'id' => 'required|integer',
            'password' => 'string',
        ]);

        $usuario = User::where("id", $params->id)->first();
        $usuario["valorant"] = $params->valorant;
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

    public function logout(Request $params) {
        $params->user()->token()->revoke();

        return response()->json([
                    'message' => 'Successfully logged out'
                        ], 200);
    }

    public function register(Request $params) {
        $params->validate([
            'nombre' => 'string|required',
            'apellidos' => 'string|required',
            'diaNacimiento' => 'required',
            'mesNacimiento' => 'required',
            'anioNacimiento' => 'required',
            'email' => 'string|required',
            'nombreUsuario' => 'string|required',
            'password' => 'string|required'
        ]);

        $user = new User([
            'id' => User::orderBy('id', 'desc')->first()->id + 1,
            'nombre' => $params->nombre,
            'apellidos' => $params->apellidos,
            'diaNacimiento' => $params->diaNacimiento,
            'mesNacimiento' => $params->mesNacimiento,
            'anioNacimiento' => $params->anioNacimiento,
            'email' => $params->email,
            'nombreUsuario' => $params->nombreUsuario,
            'password' => bcrypt($params->password),
            'estado' => 0,
            'verificado' => 0,
            'descripcion' => '',
        ]);

        $codigo = $this->generarAlfanumerico(0, 15);
        $user->remember_token = $codigo;

        $url = $_SERVER['SERVER_NAME'] . ($_SERVER['SERVER_PORT'] != 80 ? $_SERVER['SERVER_PORT'] : '') . DIRECTORY_SEPARATOR . "public" . DIRECTORY_SEPARATOR . "api" . DIRECTORY_SEPARATOR . "verify" . DIRECTORY_SEPARATOR . $codigo;

        Mail::to($user->email)->send(new Verificar($user->nombreUsuario, $url));

        if (!Mail::failures()) {
            $user->estado = 1;
            $user->save();
            asignacionRol::create([
                'id' => asignacionRol::orderBy('id', 'desc')->first()->id + 1,
                'idRol' => 3,
                'idUsuario' => $user->id
            ]);
            return response()->json([
                        'message' => 'Creacion satisfactoria, verifique su email.',
                        'code' => '201'
                            ], 201);
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

    public function verify($codigo) {
        $user = User::where('remember_token', $codigo)->first();
        if ($user != null) {
            $user->email_verified_at = time();
            $user->remember_token = null;
            $user->verificado = 1;
            $user->save();
            $url = "https://pruebas.glitchgaming.es";
            return redirect($url);
        }
    }

}
