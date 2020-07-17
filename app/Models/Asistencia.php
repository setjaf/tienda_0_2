<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $mesesTexto = [
        'enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre', 'noviembre', 'diciembre'
    ];

    protected $diasTexto = [
        'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'
    ];

    protected $fillable = [
        'idEmpleado','idTienda','entrada','salida'
    ];

    protected $casts = [
        'entrada'=>'datetime',
        'salida'=>'datetime'
    ];

    public function getFechaCompletaAttribute()
    {
        return $this->diaTexto.' '.$this->entrada->format('d').' de '.$this->mesTexto.' '.$this->entrada->format('Y');
    }

    public function getMesTextoAttribute()
    {
        return $this->mesesTexto[$this->entrada->format('n') - 1];
    }

    public function getDiaTextoAttribute()
    {
        return $this->diasTexto[$this->entrada->format('N') - 1];
    }

    // public function getSalidaAttribute()
    // {
    //     return $this->salida->format('h:i');
    // }

    // public function getEntradaAttribute()
    // {
    //     return $this->salida->format('h:i');
    // }

    // public function empleado()
    // {
    //     return $this->belongsTo('App\Models\Empleado','idEmpleado');
    // }

    // public function tienda()
    // {
    //     return $this->belongsTo('App\Models\Tienda','idTienda');
    // }


}
