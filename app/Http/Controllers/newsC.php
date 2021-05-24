<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\noticia;

class newsC extends Controller {

    function getUltimasNoticias() {
        $noticias = noticia::where("ultima", 1)
                ->get();
        return response()->json([
                    'ultimasNoticias' => ($noticias)
                        ], 200);
    }

}
