<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\juego;
use App\Models\tipo;
use App\Models\modalidad;

class juegoC extends Controller {

    public function getJuegosDisponibles() {
        $juegosDisponibles = juego::get();
        return response()->json(['juegosDisponibles' => $juegosDisponibles], 200);
    }

    public function getNombreJuego(Request $request) {
        $juego = juego::where('id', '=', $request->idJuego)->first()->juego;
        return response()->json(['juego' => $juego], 200);
    }

    public function getTipoModalidad(Request $request) {
        $tipo = tipo::where('id_juego', '=', $request->idJuego)->get();
        return response()->json(['tipoModalidad' => $tipo], 200);
    }

    public function getModalidad(Request $request) {
        $modalidad = modalidad::where('id_juego','=',$request->idJuego)->get();
        return response()->json(['modalidad' => $modalidad], 200);
    }

}
