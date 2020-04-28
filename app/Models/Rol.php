<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable =[
        'rol', 'descripcion'
    ];

    public function usuarios()
    {
        return $this->hasMany('App\Models\Usuario', 'idRol');
    }
}
