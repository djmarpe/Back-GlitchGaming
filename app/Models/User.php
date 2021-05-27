<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'user';
    
    protected $fillable = [
        'id',
        'nombre',
        'apellidos',
        'edad',
        'email',
        'contra',
        'pais',
        'nombreUsuario',
        'estado',
        'verificado',
        'descripcion',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    
    
}
