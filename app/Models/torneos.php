<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class torneos extends Model
{
    use HasFactory, Notifiable;
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
