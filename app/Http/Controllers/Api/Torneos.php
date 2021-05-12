<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\torneos;

class Torneos extends Controller {
    
    public function getTorneos() {
        $torneos = Torneos::where("ultimo",1)
                            ->get();
        dd($torneos);
        return response()->json([
                    'ultimosTorneos' => ($torneos)
                        ], 200);
    }
    
}
