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

}
