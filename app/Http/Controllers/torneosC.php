<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\torneos;
use Goutte\Client;

class torneosC extends Controller {

    function getUltimosTorneos() {
        $torneos = torneos::where("ultimo", 1)
                ->get();
        return response()->json([
                    'ultimosTorneos' => ($torneos)
                        ], 200);
    }

    //Player Stats
    public function valorant(Request $player) {
        $player = $player->getContent();
        $player = $this->string_sanitize($player);

        $quitarTexto = array(' ', '#');
        $sustitucion = array('%20', '%23');
        $jugador = str_replace($quitarTexto, $sustitucion, $player);

        //Scrap con curl
        $curl = curl_init('https://tracker.gg/valorant/profile/riot/' . $jugador . '/overview?playlist=competitive');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $page = curl_exec($curl);
        curl_close($curl);

        $re = '/<span class="valorant-highlighted-stat__value" data-v-0e94bbe2 data-v-5c633178>(.*?)<\/span>/m';

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
                    $stats = [
                        "rank" => $matches[$i][$j]
                    ];
                } else {
                    $stats = [
                        "rank" => $matches[$i][$j]
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

}
