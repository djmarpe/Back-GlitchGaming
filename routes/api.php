<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\torneosC;
use App\Http\Controllers\newsC;
use App\Http\Controllers\userC;

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

// Rutas para modificar perfil y logout con Passport + middleware
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('/editEmail', [App\Http\Controllers\userC::class, 'editEmail']);
    Route::post('/editUsername', [App\Http\Controllers\userC::class, 'editUsername']);
    Route::post('/editPassword', [App\Http\Controllers\userC::class, 'editPassword']);
    Route::post('/editDescription', [App\Http\Controllers\userC::class, 'editDescription']);
    Route::post('/logout', [App\Http\Controllers\userC::class, 'logout']);
});

Route::post('/enviarMail', [App\Http\Controllers\userC::class, 'enviarMail']);
