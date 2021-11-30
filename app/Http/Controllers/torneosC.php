<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\torneos;
use App\Models\torneo_equipo;
use App\Models\fase;
use App\Models\modalidad;
use App\Models\tipo;
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
        foreach ($arrayFases as $i => $fase){
            $tipo = tipo::where('id','=',$fase->id_tipo)->first();
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
            "modalidad" => modalidad::where('id','=',$torneo->id_modalidad)->first()->Modalidad
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

        //Scrap con curl
        $curl = curl_init('https://tracker.gg/valorant/profile/riot/' . $jugador . '/overview?playlist=competitive');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $page = curl_exec($curl);
        curl_close($curl);

        $re = '/<span class="valorant-highlighted-stat__value" data-v-0e94bbe2 data-v-88450ef0>(.*?)<\/span>/m';

        preg_match_all($re, $page, $matches, PREG_SET_ORDER, 0);
        $stats = [];
        for ($i = 0; $i < sizeof($matches) - 1; $i++) {
            for ($j = 1; $j < sizeof($matches[$i]); $j++) {

                // Los nombres de los rango nunca comienzan por numero por lo que
                // compruebo si comienza por numero, ya que la página desde 
                // donde obtengo los datos si pasas de X rango cambia la forma de 
                // representacion de los datos y hay que hacer un segundo filtrado
                if (is_numeric($matches[$i][$j][0])) {
                    $re = '/<div class="label" data-v-b39ab534>(.*?)<\/div>/m';
                    preg_match_all($re, $page, $matches, PREG_SET_ORDER, 0);
                    dd($matches);
                    $stats = [
                        "rank" => $matches[$i][$j]
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
        $reglas = torneos::where('id','=',$request->idTorneo)->first()->reglas;
        return response()->json(['reglas' => $reglas],200);
    }

}
