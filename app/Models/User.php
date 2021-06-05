<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens,
        HasFactory,
        Notifiable;

    protected $table = 'users';
    protected $fillable = [
        'nombre',
        'apellidos',
        'edad',
        'email',
        'password',
        'pais',
        'nombreUsuario',
        'estado',
        'verificado',
        'descripcion',
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'avatar',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
