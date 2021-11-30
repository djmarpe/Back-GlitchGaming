<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\torneosC;
use App\Http\Controllers\newsC;
use App\Http\Controllers\userC;
use App\Http\Controllers\adminC;
use App\Http\Controllers\foroC;
use App\Http\Controllers\equiposC;
use App\Http\Controllers\juegoC;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/ultimosTorneos', [App\Http\Controllers\torneosC::class, 'getUltimosTorneos']);

Route::get('/ultimasNoticias', [App\Http\Controllers\newsC::class, 'getUltimasNoticias']);

Route::post('/login', [App\Http\Controllers\userC::class, 'login']);

Route::post('/register', [App\Http\Controllers\userC::class, 'register']);
Route::get('/verify/{codigo}', [App\Http\Controllers\userC::class, 'verify']);

// Rutas para modificar perfil y logout con Passport + middleware
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/editEmail', [App\Http\Controllers\userC::class, 'editEmail']);
    Route::post('/editUsername', [App\Http\Controllers\userC::class, 'editUsername']);
    Route::post('/editPassword', [App\Http\Controllers\userC::class, 'editPassword']);
    Route::post('/editDescription', [App\Http\Controllers\userC::class, 'editDescription']);
    Route::post('/logout', [App\Http\Controllers\userC::class, 'logout']);
    //Equipos
    Route::post('/getEquipos', [App\Http\Controllers\equiposC::class, 'getEquipos']);
    Route::post('/getMembers', [App\Http\Controllers\equiposC::class, 'getMembers']);
    Route::post('/deleteMember', [App\Http\Controllers\equiposC::class, 'deleteMembers']);
    Route::post('/deleteTeam', [App\Http\Controllers\equiposC::class, 'deleteTeam']);
    Route::post('/exitTeam', [App\Http\Controllers\equiposC::class, 'exitTeam']);
    Route::post('/getCode', [App\Http\Controllers\equiposC::class, 'getCode']);
    Route::post('/deleteCode', [App\Http\Controllers\equiposC::class, 'deleteCode']);
    Route::post('/unirseEquipo', [App\Http\Controllers\equiposC::class, 'unirseEquipo']);
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/superAdmin/getUsers', [App\Http\Controllers\adminC::class, 'getUsers']);
    Route::post('/superAdmin/deleteUser', [App\Http\Controllers\adminC::class, 'deleteUser']);
    Route::post('/superAdmin/newUser', [App\Http\Controllers\adminC::class, 'newUser']);
    Route::post('/superAdmin/editUser', [App\Http\Controllers\adminC::class, 'editUser']);
});

Route::post('/enviarMail', [App\Http\Controllers\userC::class, 'enviarMail']);

//Foro
Route::get('/foro/getPreguntas', [App\Http\Controllers\foroC::class, 'getPreguntas']);
Route::post('/foro/setRespuesta', [App\Http\Controllers\foroC::class, 'setRespuesta']);
Route::post('/foro/deleteRespuesta', [App\Http\Controllers\foroC::class, 'deleteRespuesta']);
Route::post('/foro/addPregunta', [App\Http\Controllers\foroC::class, 'addPregunta']);


//Stats
Route::post('/juegos/valorant', [App\Http\Controllers\torneosC::class, 'valorant']);
Route::get('/juegos/lol', [App\Http\Controllers\torneosC::class, 'lol']);

Route::post('/getJuegosDisponibles', [App\Http\Controllers\equiposC::class, 'getJuegosDisponibles']);
Route::post('/createTeam', [App\Http\Controllers\equiposC::class, 'createTeam']);


Route::get('/', [App\Http\Controllers\FileController::class, 'index']);
Route::post('/files', [App\Http\Controllers\FileController::class, 'store']);
Route::delete('/files/{file}', [App\Http\Controllers\FileController::class, 'destroy']);
Route::get('/files/{file}/download', [App\Http\Controllers\FileController::class, 'download']);

//Consulta de juegos
Route::get('/juegos/juegosDisponibles', [App\Http\Controllers\juegoC::class, 'getJuegosDisponibles']);

Route::post('/juego/getTorneosProgramados', [App\Http\Controllers\torneosC::class, 'getTorneosProgramados']);
Route::post('/juego/getTorneosFinalizados', [App\Http\Controllers\torneosC::class, 'getTorneosFinalizados']);
Route::post('/juego/getTorneosEnCurso', [App\Http\Controllers\torneosC::class, 'getTorneosEnCurso']);
Route::post('/juego/getNombreJuego', [App\Http\Controllers\juegoC::class, 'getNombreJuego']);
Route::post('/juego/getTorneo', [App\Http\Controllers\torneosC::class, 'getTorneo']);

Route::post('/getFullTeam', [App\Http\Controllers\equiposC::class, 'getFullTeam']);
Route::post('/torneo/inscribirEquipo', [App\Http\Controllers\torneosC::class, 'inscribirEquipo']);
Route::post('/juego/getTipoModalidad', [App\Http\Controllers\juegoC::class, 'getTipoModalidad']);
Route::post('/juego/getModalidad', [App\Http\Controllers\juegoC::class, 'getModalidad']);
Route::post('/torneo/crearTorneo', [App\Http\Controllers\torneosC::class, 'crearTorneo']);
Route::post('/torneo/getReglas', [App\Http\Controllers\torneosC::class, 'getReglas']);
