<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class miembroEquipo extends Model
{
    use HasFactory;
    protected $table = 'miembro_equipo';
    protected $fillable = [
        'id',
        'idEquipo',
        'idJugador'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    public function equipos(){
        return $this->hasMany('App\Models\equipo','id','idEquipo');
    }

    public function miembro(){
        return $this->hasOne('App\Models\User', 'id','idJugador');
    }
}
