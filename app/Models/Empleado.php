<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $mesesTexto = [
        'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre', 'noviembre', 'diciembre'
    ];

    protected $diasTexto = [
        'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'
    ];

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario','idUsuario');
    }

    public function getInicioFechaCompletaAttribute()
    {
        return $this->inicio->format('d').' de '.$this->mesTexto.' '.$this->inicio->format('Y');
    }

    public function getMesTextoAttribute()
    {
        return $this->mesesTexto[$this->inicio->format('n') - 1];
    }

    public function getDiaTextoAttribute()
    {
        return $this->diasTexto[$this->inicio->format('N') - 1];
    }

    protected $fillable = [
        'idTienda', 'idUsuario'
    ];

    protected $casts = [
        'inicio'=>'datetime'
    ];
}
