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
        'id_equipo',
        'id_jugador'
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    public function equipos(){
        return $this->hasMany('App\Models\equipo','id','id_equipo');
    }

//    public function equipo() {
//        return $this->hasMany('App\Models\equipo','id','idEquipo');
//    }
    
    public function miembro(){
        return $this->hasOne('App\Models\User', 'id','id_jugador');
    }
}
