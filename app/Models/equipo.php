<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class equipo extends Model {

    use HasFactory;

    protected $table = 'equipo';
    protected $fillable = [
        'id',
        'nombre',
        'idCreador',
        'idJuego',
        'code',
        'max_players'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}
