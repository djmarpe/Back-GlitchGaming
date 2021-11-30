<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fase extends Model
{
    use HasFactory;
    protected $table = 'fase';
    protected $fillable = [
        'id', 
        'id_torneo', 
        'num_fase',
        'id_tipo',
        'resultado'
    ];
}
