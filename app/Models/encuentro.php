<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class encuentro extends Model
{
    use HasFactory;
    protected $table = 'encuentro';
    protected $fillable = [
        'id',
        'id_fase',
        'id_equipo1',
        'id_equipo2',
        'resultado_equipo1',
        'resultado_equipo2'
    ];
}
