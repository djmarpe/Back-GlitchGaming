<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\torneos;
use App\Models\torneo_equipo;
use App\Models\miembroEquipo;
use App\Models\User;
use App\Models\fase;
use App\Models\modalidad;
use App\Models\tipo;
use App\Models\encuentro;
use Goutte\Client;

class torneosC extends Controller {

    function getUltimosTorneos() {
        $torneos = torneos::where("ultimo", 1)
                ->get();
        return response()->json([
                    'ultimosTorneos' => ($torneos)
                        ], 200);
    }

    function getTorneosProgramados(Request $request) {
        //obtenemos todos los torneos programados
        $torneos = torneos::where('idJuego', '=', $request->idJuego)
                ->where('estado', '=', 0)
                ->get();

        //Creamos el array a devolver
        $return = [];

        //Creo el array para los datos del torneo
        $torneosAux = [];

        //Recorremos cada torneo
        foreach ($torneos as $i => $torneo) {
            //Obtengo el total de participantes en el torneo
            $cuantos = torneo_equipo::where('id_torneo', '=', $torneo->id)->get();

            //Montamos el array del torneo
            $torneosAux = [
                "id" => $torneo->id,
                "id_juego" => $torneo->id_juego,
                "dia_fin" => $torneo->dia_fin,
                "mes_fin" => $torneo->mes_fin,
                "anio_fin" => $torneo->anio_fin,
                "dia_comienzo" => $torneo->dia_comienzo,
                "mes_comienzo" => $torneo->mes_comienzo,
                "anio_comienzo" => $torneo->anio_comienzo,
                "max_players" => $torneo->max_players,
                "premio" => $torneo->premio,
                "ultimo" => $torneo->ultimo,
                "estado" => $torneo->estado,
                "nombre" => $torneo->nombre,
                "participantes" => sizeof($cuantos)
            ];

            //Vamos añadiendo cada uno de los torneos al array de vuelta
            $return = $return + [
                $i => $torneosAux
            ];
        }

        return response()->json(['torneosProgramados' => $return], 200);
    }

    function getTorneosFinalizados(Request $request) {
        //obtenemos todos los torneos programados
        $torneos = torneos::where('idJuego', '=', $request->idJuego)
                ->where('estado', '=', 2)
                ->get();

        //Creamos el array a devolver
        $return = [];

        //Creo el array para los datos del torneo
        $torneosAux = [];

        //Recorremos cada torneo
        foreach ($torneos as $i => $torneo) {
            //Obtengo el total de participantes en el torneo
            $cuantos = torneo_equipo::where('id_torneo', '=', $torneo->id)->get();

            //Montamos el array del torneo
            $torneosAux = [
                "id" => $torneo->id,
                "id_juego" => $torneo->id_juego,
                "dia_fin" => $torneo->dia_fin,
                "mes_fin" => $torneo->mes_fin,
                "anio_fin" => $torneo->anio_fin,
                "dia_comienzo" => $torneo->dia_comienzo,
                "mes_comienzo" => $torneo->mes_comienzo,
                "anio_comienzo" => $torneo->anio_comienzo,
                "max_players" => $torneo->max_players,
                "premio" => $torneo->premio,
                "ultimo" => $torneo->ultimo,
                "estado" => $torneo->estado,
                "nombre" => $torneo->nombre,
                "participantes" => sizeof($cuantos)
            ];

            //Vamos añadiendo cada uno de los torneos al array de vuelta
            $return = $return + [
                $i => $torneosAux
            ];
        }

        return response()->json(['torneosFinalizados' => $return], 200);
    }

    function getTorneosEnCurso(Request $request) {
        //obtenemos todos los torneos programados
        $torneos = torneos::where('idJuego', '=', $request->idJuego)
                ->where('estado', '=', 1)
                ->get();

        //Creamos el array a devolver
        $return = [];

        //Creo el array para los datos del torneo
        $torneosAux = [];

        //Recorremos cada torneo
        foreach ($torneos as $i => $torneo) {
            //Obtengo el total de participantes en el torneo
            $cuantos = torneo_equipo::where('id_torneo', '=', $torneo->id)->get();

            //Montamos el array del torneo
            $torneosAux = [
                "id" => $torneo->id,
                "id_juego" => $torneo->id_juego,
                "dia_fin" => $torneo->dia_fin,
                "mes_fin" => $torneo->mes_fin,
                "anio_fin" => $torneo->anio_fin,
                "dia_comienzo" => $torneo->dia_comienzo,
                "mes_comienzo" => $torneo->mes_comienzo,
                "anio_comienzo" => $torneo->anio_comienzo,
                "max_players" => $torneo->max_players,
                "premio" => $torneo->premio,
                "ultimo" => $torneo->ultimo,
                "estado" => $torneo->estado,
                "nombre" => $torneo->nombre,
                "participantes" => sizeof($cuantos)
            ];

            //Vamos añadiendo cada uno de los torneos al array de vuelta
            $return = $return + [
                $i => $torneosAux
            ];
        }

        return response()->json(['torneosEnCurso' => $return], 200);
    }

    function getTorneo(Request $request) {
        $torneo = torneos::where('id', '=', $request->idTorneo)->first();
        $cuantos = torneo_equipo::where('id_torneo', '=', $torneo->id)->get();
        $fases = [];
        $arrayFases = fase::where('id_torneo', '=', $request->idTorneo)->get();
        foreach ($arrayFases as $i => $fase) {
            $tipo = tipo::where('id', '=', $fase->id_tipo)->first();
            $fases = $fases + [
                $i => $tipo->tipo
            ];
        }
        $torneosAux = [
            "id" => $torneo->id,
            "id_juego" => $torneo->id_juego,
            "dia_fin" => $torneo->dia_fin,
            "mes_fin" => $torneo->mes_fin,
            "anio_fin" => $torneo->anio_fin,
            "dia_comienzo" => $torneo->dia_comienzo,
            "mes_comienzo" => $torneo->mes_comienzo,
            "anio_comienzo" => $torneo->anio_comienzo,
            "max_players" => $torneo->max_players,
            "premio" => $torneo->premio,
            "ultimo" => $torneo->ultimo,
            "estado" => $torneo->estado,
            "nombre" => $torneo->nombre,
            "participantes" => sizeof($cuantos),
            "fases" => $fases,
            "modalidad" => modalidad::where('id', '=', $torneo->id_modalidad)->first()->Modalidad
        ];
        return response()->json(['torneo' => $torneosAux], 200);
    }

    //Player Stats
    public function valorant(Request $player) {
        $player = $player->jugador;
        $player = $this->string_sanitize($player);

        $quitarTexto = array(' ', '#');
        $sustitucion = array('%20', '%23');
        $jugador = str_replace($quitarTexto, $sustitucion, $player);

//        return response()->json(['jugador'=>$jugador],200);
        //Scrap con curl
        $curl = curl_init('https://tracker.gg/valorant/profile/riot/' . $jugador . '/overview?playlist=competitive');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $page = curl_exec($curl);
        curl_close($curl);

//        dd($page);

        $re = '/<span class="valorant-highlighted-stat__value" data-v-0e94bbe2 data-v-2f55a7ea>(.*?)<\/span>/m';

        preg_match_all($re, $page, $matches, PREG_SET_ORDER, 0);
//        dd($matches);
        $stats = [];
        for ($i = 0; $i < sizeof($matches) - 1; $i++) {
            for ($j = 1; $j < sizeof($matches[$i]); $j++) {

                // Los nombres de los rango nunca comienzan por numero por lo que
                // compruebo si comienza por numero, ya que la página desde 
                // donde obtengo los datos si pasas de X rango cambia la forma de 
                // representacion de los datos y hay que hacer un segundo filtrado
                if (is_numeric($matches[$i][$j][0])) {
                    $re = '/<span class="valorant-highlighted-stat__label" data-v-0e94bbe2 data-v-2f55a7ea>(.*?)<\/span>/m';
                    preg_match_all($re, $page, $matches, PREG_SET_ORDER, 0);
//                    dd($matches);
                    $stats = [
                        "rank" => $matches[0][1]
                    ];
                } else {
                    $stats = [
                        "rank" => $matches[0][1]
                    ];
                }
            }
        }
        return response()->json($stats);
    }

    function string_sanitize($s) {
        $result = str_replace('"', '', $s);
        return $result;
    }

    //Función en pruebas, get league of legends player stats
    public function lol(Request $player) {
        $client = new Client();

        $crawler = $client->request('GET', 'https://www.leagueofgraphs.com/es/');

        dd($crawler);
        $form = $crawler->selectButton('Buscar')->form();
        $form['wg_q'] = $player;
        $crawler = $client->submit($form);
        dd($crawler);

        $crawler->filter('span.highlight')->each(function ($node) {
            print $node->text() . "\n \n \n";
            print "\n";
        });
    }

    public function inscribirEquipo(Request $request) {
        $nuevoEquipo = new torneo_equipo([
            'id' => sizeof(torneo_equipo::get()) + 1,
            'id_torneo' => $request->idTorneo,
            'id_equipo' => $request->idEquipo
        ]);

        if ($nuevoEquipo->save()) {
            return response()->json(['unido' => true], 200);
        } else {
            return response()->json(['unido' => false], 500);
        }
    }

    public function crearTorneo(Request $request) {
        $totalTorneos = torneos::get();

        if (torneos::where('idJuego', '=', $request->idJuego)->update(['ultimo' => 0])) {
            
        }

        $torneo = new torneos([
            "id" => sizeof($totalTorneos) + 1,
            "idJuego" => $request->idJuego,
            "dia_fin" => $request->dia_fin,
            "mes_fin" => $request->mes_fin,
            "anio_fin" => $request->anio_fin,
            "dia_comienzo" => $request->dia_comienzo,
            "mes_comienzo" => $request->mes_comienzo,
            "anio_comienzo" => $request->anio_comienzo,
            "ultimo" => 1,
            "premio" => $request->torneo_premio,
            "max_players" => $request->max_players,
            "estado" => 0,
            "nombre" => $request->torneo_nombre,
            "id_modalidad" => $request->id_modalidad,
            "reglas" => $request->reglas
        ]);

        if ($torneo->save()) {
            $ok = true;
            $idTorneoAux = torneos::where('idJuego', '=', $request->idJuego)->where('ultimo', '=', 1)->first();
            $fases = [
                "1" => (int) $request->id_fase1,
                "2" => (int) $request->id_fase2,
                "3" => (int) $request->id_fase3,
                "4" => (int) $request->id_fase4,
                "5" => (int) $request->id_fase5,
                "6" => (int) $request->id_fase6
            ];
            foreach ($fases as $i => $fase) {
                if (!empty($fase)) {
                    $cuantasFases = fase::get();
                    $newFase = new fase([
                        "id" => sizeof(fase::get()) + 1,
                        "id_torneo" => $idTorneoAux->id,
                        "id_tipo" => $fase,
                        "resultado" => "",
                        "num_fase" => $i
                    ]);

                    if (!$newFase->save()) {
                        $ok = false;
                    }
                }
            }

            if ($ok) {
                return response()->json(['creado' => true], 200);
            } else {
                return response()->json(['creado' => false], 500);
            }
        } else {
            return response()->json(['creado' => false], 500);
        }
    }

    public function getReglas(Request $request) {
        $reglas = torneos::where('id', '=', $request->idTorneo)->first()->reglas;
        return response()->json(['reglas' => $reglas], 200);
    }

    public function es1vs1(Request $request) {
        $idModalidadtorneo = torneos::where('id', '=', $request->idTorneo)->first()->id_modalidad;
        $modalidad = modalidad::where('id', '=', $idModalidadtorneo)->first()->Modalidad;

        if ($modalidad == '1vs1') {
            return response()->json(['es1vs1' => true], 200);
        } else {
            return response()->json(['es1vs1' => false], 200);
        }
    }

    public function inscribirse1vs1(Request $request) {
        $totalMiembros = torneo_equipo::get();

        $ultimoId = $totalMiembros[sizeof($totalMiembros) - 1]->id;

        $nuevoEquipo = new torneo_equipo([
            'id' => $ultimoId + 1,
            'id_torneo' => $request->idTorneo,
            'id_jugador' => $request->idJugador
        ]);

        if ($nuevoEquipo->save()) {
            return response()->json(['unido' => true], 200);
        } else {
            return response()->json(['unido' => false], 500);
        }
    }

    public function pertenezco1vs1(Request $request) {
        $existe = torneo_equipo::where('id_torneo', '=', $request->idTorneo)->where('id_jugador', '=', $request->idJugador)->get();

        if (sizeof($existe) > 0) {
            return response()->json(['pertenezco1vs1' => true], 200);
        } else {
            return response()->json(['pertenezco1vs1' => false], 200);
        }
    }

    public function comenzarTorneo(Request $request) {
        if (torneos::where('id', '=', $request->id)->update(['estado' => 1])) {
            $equipos = [];
            $todos = [];
            $idEquipo = 0;
            //Obtengo todos los equipos que estan en el torneo
            $todosEquipos = torneo_equipo::where('id_torneo', '=', $request->id)->get();
            for ($i = 0; $i < sizeof($todosEquipos); $i++) {
                $idEquipo = 0;
                $miembros = [];
                $equipo = $todosEquipos[$i];
                $idEquipo = $todosEquipos[$i]->id_equipo;
                $miembrosEquipo = miembroEquipo::where('idEquipo', '=', $idEquipo)->get();
                for ($j = 0; $j < sizeof($miembrosEquipo); $j++) {
                    //Obtengo cada nombre de Valorant de cada jugador
                    $valorantName = User::where('id', '=', $miembrosEquipo[$j]->idJugador)->first()->valorant;
                    //Obtengo sus stats
                    $rango = $this->valorantStats($valorantName);
                    if (empty($rango)) {
                        return response()->json(['rango' => 'vacio ' . $miembrosEquipo[$j]->idJugador], 500);
                    } else {
                        $miembros = $miembros + [
                            $j => $rango['rank']
                        ];
                    }
                }

                $todos = [
                    'id_equipo' => $idEquipo,
                    'jugadores' => $miembros
                ];

                $equipos = $equipos + [
                    $i => $todos
                ];
            }
            $fase = fase::where('id_torneo', '=', $request->id)->where('num_fase', '=', 1)->first()->id;
            $rangosEquipo = $this->generarEmparejamientos($equipos, $fase);
            return response()->json(['rangos' => $rangosEquipo], 200);
        } else {
            return response()->json(['comenzado' => false], 500);
        }
    }

    public function finalizarTorneo(Request $request) {
        if (torneos::where('id', '=', $request->id)->update(['estado' => 2])) {
            return response()->json(['finalizado' => true], 200);
        } else {
            return response()->json(['finalizado' => false], 500);
        }
    }

    function valorantStats($nombreJugador) {
        $player = $this->string_sanitize($nombreJugador);

        $quitarTexto = array(' ', '#');
        $sustitucion = array('%20', '%23');
        $jugador = str_replace($quitarTexto, $sustitucion, $player);

//        return response()->json(['jugador'=>$jugador],200);
        //Scrap con curl
        $curl = curl_init('https://tracker.gg/valorant/profile/riot/' . $jugador . '/overview?playlist=competitive');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $page = curl_exec($curl);
        curl_close($curl);

//        dd($page);

        $re = '/<span class="valorant-highlighted-stat__value" data-v-0e94bbe2 data-v-2f55a7ea>(.*?)<\/span>/m';

        preg_match_all($re, $page, $matches, PREG_SET_ORDER, 0);
//        dd($matches);
        $stats = [];
        for ($i = 0; $i < sizeof($matches) - 1; $i++) {
            for ($j = 1; $j < sizeof($matches[$i]); $j++) {

                // Los nombres de los rango nunca comienzan por numero por lo que
                // compruebo si comienza por numero, ya que la página desde 
                // donde obtengo los datos si pasas de X rango cambia la forma de 
                // representacion de los datos y hay que hacer un segundo filtrado
                if (is_numeric($matches[$i][$j][0])) {
                    $re = '/<span class="valorant-highlighted-stat__label" data-v-0e94bbe2 data-v-2f55a7ea>(.*?)<\/span>/m';
                    preg_match_all($re, $page, $matches, PREG_SET_ORDER, 0);
//                    dd($matches);
                    $stats = [
                        "rank" => $matches[0][1]
                    ];
                } else {
                    $stats = [
                        "rank" => $matches[0][1]
                    ];
                }
            }
        }
        return $stats;
    }

    function generarEmparejamientos($equipos, $fase) {
        //Contador de totales
        $totalMiembros = 0;
        $rangosEquipo = [];
        //Recorremos todos los equipos
        foreach ($equipos as $i => $equipo) {
            $id_equipo = $equipo['id_equipo'];
            $puntos = 0;
            $hierro = 0;
            $plata = 0;
            $oro = 0;
            $platino = 0;
            $diamante = 0;
            $immortal = 0;
            $radiante = 0;
            $rangoEquipo = 0;
            $equipoAux = [];
            foreach ($equipo['jugadores'] as $j => $miembro) {
                switch ($miembro) {
                    case 'Iron 1':
                    case 'Iron 3':
                    case 'Iron 3':
                        $puntos += 5;
                        $totalMiembros++;
                        $hierro++;
                        break;
                    case 'Silver 1':
                    case 'Silver 2':
                    case 'Silver 3':
                        $puntos += 10;
                        $totalMiembros++;
                        $plata++;
                        break;
                    case 'Gold 1':
                    case 'Gold 2':
                    case 'Gold 3':
                        $puntos += 15;
                        $totalMiembros++;
                        $oro++;
                        break;
                    case 'Platinum 1':
                    case 'Platinum 2':
                    case 'Platinum 3':
                        $puntos += 20;
                        $totalMiembros++;
                        $platino++;
                        break;
                    case 'Diamond 1':
                    case 'Diamond 2':
                    case 'Diamond 3':
                        $puntos += 25;
                        $totalMiembros++;
                        $diamante++;
                        break;
                    case 'Immortal':
                        $puntos += 30;
                        $totalMiembros++;
                        $immortal++;
                        break;
                    case 'Radiant':
                        $puntos += 35;
                        $totalMiembros++;
                        $radiante++;
                        break;
                }
            }
            //Comprobamos la puntuacion obtenida y determinamos el rango del equipo
            if ($puntos >= 25 && $puntos < 50) {
                $rangoEquipo = 'Hierro';
            } else {
                if ($puntos >= 50 && $puntos < 75) {
                    $rangoEquipo = 'Plata';
                } else {
                    if ($puntos >= 75 && $puntos < 100) {
                        $rangoEquipo = 'Oro';
                    } else {
                        if ($puntos >= 100 && $puntos < 125) {
                            $rangoEquipo = 'Platino';
                        } else {
                            if ($puntos >= 125 && $puntos < 150) {
                                $rangoEquipo = 'Diamante';
                            } else {
                                if ($puntos >= 150 && $puntos < 175) {
                                    $rangoEquipo = 'Immortal';
                                } else {
                                    if ($puntos == 175) {
                                        $rangoEquipo = 'Radiante';
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $equipoAux = $equipoAux + [
                'id_equipo' => $id_equipo,
                'rango' => $rangoEquipo
            ];
            $rangosEquipo = $rangosEquipo + [
                $i => $equipoAux,
            ];
        }

        $equiposHierro = [];
        $equiposPlata = [];
        $equiposOro = [];
        $equiposPlatino = [];
        $equiposDiamante = [];
        $equiposImmortal = [];
        $equiposRadiante = [];
        $llegamos = [];

        $equiposSobrantes = [];

        $contSobrante = 0;
        $contHierro = 0;
        $contPlata = 0;
        $contOro = 0;
        $contPlatino = 0;
        $contDiamante = 0;
        $contImmortal = 0;
        $contRadiante = 0;
        
        foreach ($rangosEquipo as $clave => $equipoOK) {
            switch ($equipoOK['rango']) {
                case 'Hierro':
                    $equiposHierro += [$contHierro => $equipoOK];
                    $contHierro++;
                    break;
                case 'Plata':
                    $equiposPlata += [$contPlata => $equipoOK];
                    $contPlata++;
                    break;
                case 'Oro':
                    $equiposOro += [$contOro => $equipoOK];
                    $contOro++;
                    break;
                case 'Platino':
                    $equiposPlatino += [$contPlatino => $equipoOK];
                    $contPlatino++;
                    break;
                case 'Diamante':
                    $equiposDiamante += [$contDiamante => $equipoOK];
                    $contDiamante++;
                    break;
                case 'Immortal':
                    $equiposImmortal += [$contImmortal => $equipoOK];
                    $contImmortal++;
                    break;
                case 'Radiante':
                    $equiposRadiante += [$contRadiante => $equipoOK];
                    $contRadiante++;
                    break;
            }
            $llegamos = [
                'equiposHierro' => $equiposHierro,
                'equiposPlata' => $equiposPlata,
                'equiposOro' => $equiposOro,
                'equiposPlatino' => $equiposPlatino,
                'equiposDiamante' => $equiposDiamante,
                'equiposImmortal' => $equiposImmortal,
                'equiposRadiante' => $equiposRadiante
            ];
        }

//        return $llegamos;
        //Miramos cuantos equipos hay del mismo rango para hacer el matchmaking

        if (sizeof($equiposHierro) > 0) {
            if (is_int(sizeof($equiposHierro) / 2)) {
                $i = 0;
                while ($i < sizeof($equiposHierro)) {
                    $equipo1 = $equiposHierro[$i];
                    $i++;
                    $equipo2 = $equiposHierro[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposHierro)) {
//                    return 'generado';
//                }
            } else {
                $equipoHierroAux = end($equiposHierro);
                $equiposSobrantes += [$contSobrante => $equipoHierroAux];
                $contSobrante++;
                $i = 0;
                while ($i < sizeof($equiposHierro)-1) {
                    $equipo1 = $equiposHierro[$i];
                    $i++;
                    $equipo2 = $equiposHierro[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposHierro)) {
//                    return 'generado';
//                }
            }
        }
        if (sizeof($equiposPlata) > 0) {
            if (is_int(sizeof($equiposPlata) / 2)) {
                $i = 0;
                while ($i < sizeof($equiposPlata)) {
                    $equipo1 = $equiposPlata[$i];
                    $i++;
                    $equipo2 = $equiposPlata[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposPlata)) {
//                    return 'generado';
//                }
            } else {
                $equipoPlataAux = end($equiposPlata);
                $equiposSobrantes += [$contSobrante => $equipoPlataAux];
                $contSobrante++;
                $i = 0;
                while ($i < sizeof($equiposPlata)-1) {
                    $equipo1 = $equiposPlata[$i];
                    $i++;
                    $equipo2 = $equiposPlata[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposPlata)) {
//                    return 'generado';
//                }
            }
        }
        if (sizeof($equiposOro) > 0) {
            if (is_int(sizeof($equiposOro) / 2)) {
                $i = 0;
                while ($i < sizeof($equiposOro)) {
                    $equipo1 = $equiposOro[$i];
                    $i++;
                    $equipo2 = $equiposOro[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposOro)) {
//                    return 'generado';
//                }
            } else {
                $equipoOroAux = end($equiposOro);
                $equiposSobrantes += [$contSobrante => $equipoOroAux];
                $contSobrante++;
                $i = 0;
                while ($i < sizeof($equiposOro)-1) {
                    $equipo1 = $equiposOro[$i];
                    $i++;
                    $equipo2 = $equiposOro[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposOro)) {
//                    return 'generado';
//                }
            }
        }
        if (sizeof($equiposPlatino) > 0) {
            if (is_int(sizeof($equiposPlatino) / 2)) {
                $i = 0;
                while ($i < sizeof($equiposPlatino)) {
                    $equipo1 = $equiposPlatino[$i];
                    $i++;
                    $equipo2 = $equiposPlatino[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposPlatino)) {
//                    return 'generado';
//                }
            } else {
                $equipoPlatinoAux = end($equiposPlatino);
                $equiposSobrantes += [$contSobrante => $equipoPlatinoAux];
                $contSobrante++;
                $i = 0;
                while ($i < sizeof($equiposPlatino)-1) {
                    $equipo1 = $equiposPlatino[$i];
                    $i++;
                    $equipo2 = $equiposPlatino[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposPlatino)) {
//                    return 'generado';
//                }
            }
        }
        if (sizeof($equiposDiamante) > 0) {
            if (is_int(sizeof($equiposDiamante) / 2)) {
                $i = 0;
                while ($i < sizeof($equiposDiamante)) {
                    $equipo1 = $equiposDiamante[$i];
                    $i++;
                    $equipo2 = $equiposDiamante[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposDiamante)) {
//                    return 'generado';
//                }
            } else {
                $equipoDiamanteAux = end($equiposDiamante);
                $equiposSobrantes += [$contSobrante => $equipoDiamanteAux];
                $contSobrante++;
                $i = 0;
                while ($i < sizeof($equiposDiamante)-1) {
                    $equipo1 = $equiposDiamante[$i];
                    $i++;
                    $equipo2 = $equiposDiamante[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposDiamante)) {
//                    return 'generado';
//                }
            }
        }
        if (sizeof($equiposImmortal) > 0) {
            if (is_int(sizeof($equiposImmortal) / 2)) {
                $i = 0;
                while ($i < sizeof($equiposImmortal)) {
                    $equipo1 = $equiposImmortal[$i];
                    $i++;
                    $equipo2 = $equiposImmortal[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposImmortal)) {
//                    return 'generado';
//                }
            } else {
                $equipoImmortalAux = end($equiposImmortal);
                $equiposSobrantes += [$contSobrante => $equipoImmortalAux];
                $contSobrante++;
                $i = 0;
                while ($i < sizeof($equiposImmortal)-1) {
                    $equipo1 = $equiposImmortal[$i];
                    $i++;
                    $equipo2 = $equiposImmortal[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposImmortal)) {
//                    return 'generado';
//                }
            }
        }
        if (sizeof($equiposRadiante) > 0) {
            if (is_int(sizeof($equiposRadiante) / 2)) {
                $i = 0;
                while ($i < sizeof($equiposRadiante)) {
                    $equipo1 = $equiposRadiante[$i];
                    $i++;
                    $equipo2 = $equiposRadiante[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposRadiante)) {
//                    return 'generado';
//                }
            } else {
                $equipoRadianteAux = end($equiposRadiante);
                $equiposSobrantes += [$contSobrante => $equipoRadianteAux];
                $contSobrante++;
                $i = 0;
                while ($i < sizeof($equiposRadiante)-1) {
                    $equipo1 = $equiposRadiante[$i];
                    $i++;
                    $equipo2 = $equiposRadiante[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
//                if ($i >= sizeof($equiposRadiante)) {
//                    return 'generado';
//                }
            }
        }

//        return $equiposSobrantes;
        
        if (sizeof($equiposSobrantes) > 0) {
            if (is_int(sizeof($equiposSobrantes) / 2)) {
                $i = 0;
                while ($i < sizeof($equiposSobrantes)) {
                    $equipo1 = $equiposSobrantes[$i];
                    $i++;
                    $equipo2 = $equiposSobrantes[$i];
                    $encuentro = new encuentro([
                        'id_fase' => $fase,
                        'id_equipo1' => $equipo1['id_equipo'],
                        'id_equipo2' => $equipo2['id_equipo'],
                        'resultado_equipo1' => 0,
                        'resultado_equipo2' => 0
                    ]);
                    $encuentro->save();
                    $i++;
                }
                if ($i >= sizeof($equiposSobrantes)) {
                    return 'generado';
                }
            }
        }
    }

    public function getFases(Request $params) {
        return response()->json(['idTorneo' => $params->id], 200);
    }

}
