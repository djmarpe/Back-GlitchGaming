<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class torneo_equipo extends Model
{
    use HasFactory;
    
    protected $table = 'torneo_equipo';
    protected $fillable = [
        'id',
        'id_torneo',
        'id_equipo',
        'id_jugador'
    ];
}
