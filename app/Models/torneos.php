<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\torneo_equipo;

class torneos extends Model {

    use HasFactory;

    protected $fillable = [
        'id',
        'idJuego',
        'dia_fin',
        'mes_fin',
        'anio_fin',
        'dia_comienzo',
        'mes_comienzo',
        'anio_comienzo',
        'max_players',
        'premio',
        'ultimo',
        'estado',
        'nombre',
        'id_modalidad',
        'reglas'
    ];

}
