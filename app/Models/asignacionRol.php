<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asignacionRol extends Model
{
    use HasFactory;
    protected $table = 'asignacionRol';
    
    protected $fillable = [
        'idRol',
        'idUsuario',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function roles(){
        return $this->hasOne('App\Models\rol','id','idRol');
    }

    public function users(){
        return $this->hasOne('App\Models\User', 'id','idUsuario');
    }
}
