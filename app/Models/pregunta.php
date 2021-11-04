<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pregunta extends Model
{
    use HasFactory;
    
    protected $table = 'pregunta';
    
    protected $fillable = [
        'id',
        'idUsuarioCreador',
        'descripcion',
    ];
    
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    public function respuestas() {
        return $this->hasMany('App\Models\respuesta', 'idPregunta','id');
    }
    
    public function users() {
        return $this->hasMany('App\Models\User', 'id','idUsuarioCreador');
    }
}
