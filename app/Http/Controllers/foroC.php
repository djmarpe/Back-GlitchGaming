<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\asignacionRol;
use App\Models\rol;
use App\Models\pregunta;
use App\Models\respuesta;
use App\Mail\Preguntas;
use App\Mail\Verificar;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class foroC extends Controller {

    public function getPreguntas(Request $params) {
        //Obtenemos todas las preguntas en bruto
        $preguntas = pregunta::with("respuestas")->get();

        //Array a devolver
        $todasPreguntas;

        $return = [];

        //Recorremos el array con las preguntas y sus respuestas
        foreach ($preguntas as $i => $pregunta) {
            //Recogemos la pregunta
            $preguntaAux2 = $pregunta;
            $preguntaAux2 = [
                "id" => $pregunta->id,
                "usuarioCreador" => User::where("id", $pregunta->idUsuarioCreador)->first(),
                "pregunta" => $pregunta->descripcion,
            ];

            //Creamos el array 
            $respuestasAux = [];

            foreach ($pregunta->respuestas as $k => $respuesta) {
                //Recogemos cada una de las respuestas
                $respuestaAux = [
                    "id" => $respuesta->id,
                    "idPregunta" => $respuesta->idPregunta,
                    "usuarioResponde" => User::where("id", $respuesta->idUsuarioResponde)->first(),
                    "descripcion" => $respuesta->descripcion
                ];
                //Añadimos las respuestas en el array de respuestas
                $respuestasAux[] = $respuestaAux;
            }
            //Montamos el array que vamos a devolver con pregunta mas conj de respuestas
            $preguntaAux3 = [
                "pregunta" => $preguntaAux2,
                "respuestas" => $respuestasAux
            ];
            //Añadimos la pregunta al array general a devolver
            $return[] = $preguntaAux3;
        }

        $todasPreguntas = [
            "listaPreguntas" => $return
        ];

        return $todasPreguntas;
    }

    public function setRespuesta(Request $params) {
        $respuesta = new respuesta([
            'idUsuarioResponde' => $params->idUsuarioRespuesta,
            'idPregunta' => $params->idPregunta,
            'descripcion' => $params->respuesta
        ]);

        $respuesta->save();

        return response()->json([
                    'message' => 'Respuesta creada',
                    'code' => '201'
                        ], 201);
    }

    public function deleteRespuesta(Request $params) {
        if (respuesta::where("id", $params->id)->delete()) {
            return response()->json([
                        'message' => 'Respuesta eliminada',
                        'code' => '201'
                            ], 201);
        }
    }

    public function addPregunta(Request $params) {
        $pregunta = new pregunta([
            'idUsuarioCreador' => $params->idCreador,
            'descripcion' => $params->descripcion
        ]);
        if ($pregunta->save()) {
            $response = response()->json([
                'message' => 'Creacion satisfactoria',
                'code' => '201'
                    ], 200);
        } else {
            $response = response()->json([
                'message' => 'Error del servidor',
                'code' => '500'
                    ], 500);
        }
    }
}
