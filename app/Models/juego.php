<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class juego extends Model
{
    use HasFactory;
    
    protected $table = 'juego';
    
    protected $fillable = [
        'id',
        'juego',
    ];
}
