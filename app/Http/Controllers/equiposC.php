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
                "idCreador" => $equipo->equipos[0]->idCreador,
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

    public function getMembers(Request $request) {
        //Obtenemos los nombres de los jugadores que pertenecen a un equipo concreto
        $miembros = miembroEquipo::with("miembro")
                ->where('idEquipo', $request->idEquipo)
                ->get();

        $return = [];
        $miembro = [];

        foreach ($miembros as $i => $miembro) {
            $miembro = [
                "id" => $miembro->miembro->id,
                "nombreUsuario" => $miembro->miembro->nombreUsuario
            ];
            $return = $return + [
                $i => $miembro
            ];
        }
        return response()->json(["miembros" => $return], 200);
    }

    public function deleteMembers(Request $request) {
        if (miembroEquipo::where('idEquipo', '=', $request->idEquipo)
                        ->where('idJugador', '=', $request->idJugador)
                        ->delete()) {

            return response()->json(['borrado' => 'ok'], 200);
        } else {
            return response()->json(['borrado' => 'error'], 500);
        }
    }

    public function deleteTeam(Request $request) {
        if (miembroEquipo::where('idEquipo', '=', $request->idEquipo)->delete()) {
            if (equipo::where('id', '=', $request->idEquipo)->delete()) {
                return response()->json(['borrado' => 'ok'], 200);
            }
        } else {
            return response()->json(['borrado' => 'error'], 500);
        }
    }

}
