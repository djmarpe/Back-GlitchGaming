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
    ];
    
    public function encuentro() {
        return $this->hasMany('App\Models\encuentro','id_fase','id');
    }
    
    public function tipo() {
        return $this->hasOne('App\Models\tipo','id','id_tipo');
    }
}
