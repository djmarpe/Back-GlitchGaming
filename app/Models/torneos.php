<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class torneos extends Model {

    use HasFactory;

    protected $fillable = [
        'id',
        'idJuego',
        'diaFin',
        'mesFin',
        'anioFin',
        'diaComienzo',
        'mesComienzo',
        'anioComienzo',
        'equiposInscritos',
        'premio',
        'ultimo',
    ];

}
