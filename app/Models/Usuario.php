<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Usuario extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public function rol()
    {
        return $this->belongsTo('App\Models\Rol','idRol');
    }

    public function persona()
    {
        return $this->belongsTo('App\Models\Persona','idPersona');
    }

    public function administra(){
        return $this->hasMany('App\Models\Tienda','idUsuario');
    }

    public function trabajaEn(){
        return $this->belongsToMany('App\Models\Tienda','empleados','idUsuario','idTienda')->withPivot('id','sueldo', 'formaPago', 'inicio');
    }

    public function cierres()
    {
        return $this->hasMany('App\Models\Cierre','idUsuario');
    }

    public function tiendas()
    {
        return $this->hasMany('App\Models\Tienda','idUsuario');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idPersona','idRol','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //
}
