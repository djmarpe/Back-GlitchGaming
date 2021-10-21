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
//        return response()->json([
//            "jugador"=>$player
//        ],200);
        $quitarTexto = array(' ', '#');
        $sustitucion = array('%20', '%23');
        $jugador = str_replace($quitarTexto, $sustitucion, $player);
//        return response()->json([
//            "jugador" => $jugador
//        ], 200);
        //Scrap con curl
        $curl = curl_init('https://tracker.gg/valorant/profile/riot/'.$jugador.'/overview?playlist=competitive');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $page = curl_exec($curl);

//        if (curl_errno($curl)) { // check for execution errors 
//            echo 'Error del scraper: ' . curl_error($curl);
//            exit;
//        }
        curl_close($curl);

        $re = '/<span class="valorant-highlighted-stat__value" data-v-0e94bbe2 data-v-5c633178>(.*?)<\/span>/m';

        preg_match_all($re, $page, $matches, PREG_SET_ORDER, 0);
        $stats = [];
        foreach ($matches as $i => $val1) {
            for ($j = 1; $j < sizeof($val1); $j++) {
                $stats = [
                    "kda" => $val1[$j]
                ];
            }
        }

//        dd($valores);
//        $stats = [
//          "rank" => $matches[0][1],
//          "kda" => $matches[1][1]
//        ];
//        
        return response()->json($stats);

//        $client = new Client();
//
//
//        $crawler = $client->request('GET', 'https://tracker.gg/valorant/profile/riot/' . $jugador . '/overview?playlist=competitive');
//        dd($crawler->filter('span.valorant-highlighted-stat__value'));
//        $crawler->filter('span.valorant-highlighted-stat__value')->each(function ($node) {
//            print $node->text();
//            print "\n";
//        });
//        $rank = $crawler->filter('span.valorant-highlighted-stat__value')->getNode(0)->textContent;
//        $kda = $crawler->filter('span.valorant-highlighted-stat__value')->getNode(1)->textContent;
//        return response()->json([
//                    'rank' => $rank,
//                    'KDA' => $kda
//                        ], 200);
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
