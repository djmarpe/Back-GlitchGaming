<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\torneos;

class torneosC extends Controller {
    
    function getUltimosTorneos() {
        $torneos = torneos::where("ultimo",1)
                        ->get();
        return response()->json([
                    'ultimosTorneos' => ($torneos)
                        ], 200);
    }
    
}
