<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class respuesta extends Model
{
    use HasFactory;
    
    protected $table = 'respuesta';
    
    protected $fillable = [
        'id',
        'idPregunta',
        'idUsuario',
        'descripcion',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
