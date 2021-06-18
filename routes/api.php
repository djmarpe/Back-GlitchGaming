<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\torneosC;
use App\Http\Controllers\newsC;
use App\Http\Controllers\userC;
use App\Http\Controllers\adminC;

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
});

Route::group(['middleware' => 'auth:api'], function() {
   Route::get('/superAdmin/getUsers', [App\Http\Controllers\adminC::class, 'getUsers']);
   Route::post('/superAdmin/deleteUser', [App\Http\Controllers\adminC::class, 'deleteUser']);
   Route::post('/superAdmin/newUser', [App\Http\Controllers\adminC::class, 'newUser']);
   Route::post('/superAdmin/editUser', [App\Http\Controllers\adminC::class, 'editUser']);
});

Route::post('/enviarMail', [App\Http\Controllers\userC::class, 'enviarMail']);
