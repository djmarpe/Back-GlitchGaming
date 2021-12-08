<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class modalidad extends Model
{
    use HasFactory;
    protected $table = 'modalidad';
    protected $fillable = [
        'id', 
        'id_juego',
        'modalidad'
    ];
}
