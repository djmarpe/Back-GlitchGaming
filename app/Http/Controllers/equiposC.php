<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\equipo;
use App\Models\miembroEquipo;
use App\Models\juego;
use App\Models\torneo_equipo;

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

//        return response()->json(["miembros" => $miembros[0]->id], 200);
        foreach ($miembros as $i => $miembro) {
//            return response()->json(["miembro" => User::where('id','=',$miembro->id)->first()->nombreUsuario], 200);
            $miembro = [
                "id" => $miembro->id,
                "nombreUsuario" => User::where('id','=',$miembro->id)->first()->nombreUsuario
//                "nombreUsuario" => $miembro->miembro->nombreUsuario
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

    public function exitTeam(Request $request) {
        //Elimino al jugador de la tabla miembro_equipo
        if (miembroEquipo::where('idJugador', '=', $request->idJugador)
                        ->where('idEquipo', '=', $request->idEquipo)
                        ->delete()) {
            //Compruebo que no sea el último miembro del equipo
            if (sizeof(miembroEquipo::with("miembro")
                                    ->where('idEquipo', $request->idEquipo)
                                    ->get()) > 1) {
                //Si hay mas de un miembro, miro si es el creador
                if (equipo::where('idCreador', '=', $request->idJugador)) {
                    //Si es el creador, le pasamos el admin a otro jugador aleatorio
                    //del equipo
                    if ($this->setNewAdmin($request->idEquipo, $request->idJugador)) {
                        return response()->json(['nuevoAdmin' => 'ok'], 200);
                    } else {
                        return response()->json(['nuevoAdmin' => 'error'], 500);
                    }
                    return response()->json(['salida' => 'ok'], 200);
                } else {
                    return response()->json(['salida' => 'error'], 500);
                }
            } else {
                //Si es el ultimo jugador, borramos el equipo directamente
                if (equipo::where('id', '=', $request->idEquipo)->delete()) {
                    return response()->json(['salida' => 'ok'], 200);
                }
            }
        }
    }

    public function setNewAdmin($idEquipo, $idJugador) {
        //Obtenemos los nombres de los jugadores que pertenecen a un equipo concreto
        $miembros = miembroEquipo::with("miembro")
                ->where('idEquipo', '=', $idEquipo)
                ->get();
        $alea = rand(0, sizeof($miembros) - 1);

        $miembroSeleccionado = $miembros[$alea];

        //Seteamos el nuevo admin del equipo
        if (equipo::where('id', '=', $idEquipo)
                        ->where('idCreador', '=', $idJugador)
                        ->update(['idCreador' => $miembroSeleccionado->miembro->id])) {
            return true;
        } else {
            return false;
        }
    }

    public function getCode(Request $request) {
        $equipos = equipo::all();

        if (sizeof($equipos) > 0) {
            $i = 0;
            while ($i < sizeof($equipos)) {
                $colocado = false;
                while (!$colocado) {
                    $alea = rand(100000, 999999);
                    $repetido = false;
                    foreach ($equipos as $k => $equipo) {
                        if ($equipo->code == $alea) {
                            $repetido = true;
                        }
                    }

                    if (!$colocado && !$repetido) {
                        equipo::where('id', '=', $request->idEquipo)->update(['code' => $alea]);
                        $colocado = true;
                        $i++;
                        return response()->json(['accessCode' => $alea], 200);
                    }
                }
            }
        }
    }

    public function deleteCode(Request $request) {
        if (equipo::where('id', '=', $request->idEquipo)
                        ->update(['code' => null])) {
            return response()->json(['exito' => true], 200);
        } else {
            return response()->json(['exito' => false], 500);
        }
    }

    public function unirseEquipo(Request $request) {
        $idJugador = $request->idJugador;
        $codigo = $request->codigo;
        $equipo = equipo::where('code', '=', $codigo)->first();

        //comprobamos si hay algun equipo con ese codigo de acceso
        if ($equipo != null) {
            $idEquipo = $equipo->id;
            //Obtenemos los miembros del equipo
            $miembros = miembroEquipo::where('idEquipo', '=', $idEquipo)->get();
            //Comprobamos si hay miembros y los miembros son menores que el maximo de jugadores
            if (sizeof($miembros) > 0 && sizeof($miembros) < $equipo->max_players) {
                $existe = false;
                //Miramos todos los miembros de ese equipo
                foreach ($miembros as $i => $miembro) {
                    //Si hay algun miembro que tiene el mismo id
                    if ($miembro->idJugador == $idJugador) {
                        $existe = true;
                        //Devolvemos error
                        return response()->json(['unirse' => false], 403);
                    }
                }
                //Si no existe ese jugador
                if (!$existe) {
                    //Obtenemos el total de miembros
                    $total = miembroEquipo::get();
                    //Creamos el registro
                    $newMember = new miembroEquipo([
                        'id' => sizeof($total) + 1,
                        'idEquipo' => $idEquipo,
                        'idJugador' => $idJugador,
                    ]);
                    //Salvamos en la BBDD
                    $newMember->save();
                    //Devolvemos el ok
                    return response()->json(['unirse' => true], 200);
                }
            }
        }
    }

    public function getJuegosDisponibles() {
        $juegos = juego::get();
        return response()->json(['juegos' => $juegos]);
    }

    public function createTeam(Request $request) {
        $idCreador = $request->idCreador;
        $idJuego = $request->idJuego;
        $maxPlayers = $request->maxPlayers;
        $nombre = $request->newNombre;

        //Obtenemos los equipos que haya creado ese jugador con esa Id de juego
        $equipos = equipo::where('idCreador', '=', $idCreador)
                        ->where('idJuego', '=', $idJuego)->get();

        //Si hay algun equipo
        if (sizeof($equipos) > 0) {
            //Devolvemos error
            return response()->json(['existe' => false], 403);
            //Si no tiene equipos en los cuales sea creador con esa ID de juego
        } else {
            //Obtenemos el total de equipo
            $totalEquipos = equipo::get();

            //Creamos el nuevo equipo
            $newTeam = new equipo([
                'id' => sizeof($totalEquipos) + 1,
                'nombre' => $nombre,
                'idCreador' => $idCreador,
                'idJuego' => $idJuego,
                'code' => null,
                'max_players' => $maxPlayers
            ]);

            //Si lo guarda bien
            if ($newTeam->save()) {
                //Creamos el miembro nuevo
                $miembroNuevo = new miembroEquipo([
                    'id' => sizeof(miembroEquipo::get()) + 1,
                    'idEquipo' => sizeof($totalEquipos) + 1,
                    'idJugador' => $idCreador
                ]);
                //Si lo guarda bien
                if ($miembroNuevo->save()) {
                    //Devolvemos true 
                    return response()->json(['creado' => true], 200);
                } else {
                    return response()->json(['creado' => false], 500);
                }
            } else {
                return response()->json(['creado' => false], 500);
            }
        }
    }

    public function getFullTeam(Request $request) {
        //Miramos si soy dueño de algun equipo del juego que le pasemos
        $miEquipo = equipo::where('idCreador', '=', $request->idJugador)
                        ->where('idJuego', '=', $request->idJuego)->get();

        //Si soy sueño de algun equipo
        if (sizeof($miEquipo) > 0) {
            $miEquipoAux = [];
            //Devuelvo a ese equipo que quiero inscribir en el torneo
            $miEquipoAux = [
                'id' => $miEquipo[0]->id,
                'nombre' => $miEquipo[0]->nombre,
                'idCreador' => $miEquipo[0]->idCreador,
                'idJuego' => $miEquipo[0]->idJuego,
                'max_players' => $miEquipo[0]->max_players,
                'participantes' => sizeof(miembroEquipo::where('idEquipo', '=', $miEquipo[0]->id)->get()),
                'pertenece' => sizeof(torneo_equipo::where('id_equipo','=',$miEquipo[0]->id)->where('id_torneo','=',$request->idTorneo)->get())
            ];
            return response()->json(['miEquipo' => $miEquipoAux], 200);

            //Si no soy dueño de ningun equipo
        } else {
            //Miro si pertenezco a algun equipo
            $equiposPertenezco = miembroEquipo::where('idJugador', '=', $request->idJugador)->get();
//            return response()->json(['equipos' => $equiposPertenezco], 200);
            //Creo el array que va a tener los equipos a los que pertenezco
            $return = [];
            //Recorremos todos los equipos a los que pertenezco
            foreach ($equiposPertenezco as $i => $equipo) {
                //Miro el equipo principal al cual pertenezco
                $equipoAux2 = equipo::where('id', '=', $equipo->idEquipo)->first();
                //Miro si el juego del que trata es el mismo que el del torneo
                //Si trata sobre el mismo juego
                $equipoPadre = [];
                if ($equipoAux2->idJuego == $request->idJuego) {
                    $equipoPadre = [
                        'id' => $equipoAux2->id,
                        'nombre' => $equipoAux2->nombre,
                        'idCreador' => $equipoAux2->idCreador,
                    ];
                }
                $return = $return + [
                    $i => $equipoPadre
                ];
            }
            return response()->json(['equipos' => $return], 200);
        }
    }

}
