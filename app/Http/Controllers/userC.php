<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userC extends Controller {

    function existeUsuario(Request $request) {
        var_dump($request);

        return response()->json([
                    'existe' => ('OK')
                        ], 200);
    }

}
