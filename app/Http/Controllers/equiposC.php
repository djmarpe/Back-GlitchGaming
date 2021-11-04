<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\equipo;
use App\Models\miembroEquipo;
use App\Models\juego;

class equiposC extends Controller {

    public function getEquipos(Request $request) {
        //Obtengo todos los equipos en los que estoy
        $equipos = miembroEquipo::with("equipos")
                ->where("idJugador", $request->id)
                ->get();

        //Creo el array a devolver
        $return = [];

        //Creo el array que contendrá los datos del equipo
        $teams = [];

        //Recorro cada equipo en el que estoy
        foreach ($equipos as $i => $equipo) {

            //Obtengo el juego de que trata a través de la idJuego del equipo
            $juego = juego::where('id', json_decode($equipo->equipos[0]->idJuego))->first();

            //Obtengo cuantos miembros hay en el equipo
            $cuantos = miembroEquipo::where("idEquipo", json_decode($equipo->equipos[0]->id))->count();

            //Monto el array del equipo
            $teams = [
                "idEquipo" => json_decode($equipo->equipos[0]->id),
                "nombre" => $equipo->equipos[0]->nombre,
                "juego" => $juego->juego,
                "miembros" => $cuantos
            ];

            //Monto el array a devolver respetando lo que tuviera anteriormente si se da el caso
            $return = $return + [
                $i => $teams
            ];
        }

        return response()->json(["equipos" => $return], 200);
    }

}
