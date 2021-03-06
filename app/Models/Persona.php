<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    public function usuario()
    {
        return $this->hasOne('App\Models\Usuario','idPersona');
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->paterno} {$this->materno}";
    }

    public $fillable = [
        'nombre', 'paterno', 'materno', 'fecha_nacimiento', 'curp', 'rfc', 'telefono'
    ];


}
