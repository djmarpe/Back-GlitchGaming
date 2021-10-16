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
        $client = new Client();

        $quitarTexto = array(' ', '#');
        $sustitucion = array('%20', '%23');
        $jugador = str_replace($quitarTexto, $sustitucion, $player->player);

        $crawler = $client->request('GET', 'https://tracker.gg/valorant/profile/riot/' . $jugador . '/overview?playlist=competitive');
        print $crawler->filter('span.valorant-highlighted-stat__value')->getNode(1)->textContent;
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
