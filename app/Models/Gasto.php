<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $fillable = [
        'idTipoGasto', 'idUsuario','idTienda','importe', 'fecha','descripcion'
    ];

    public function tipoGasto()
    {
        return $this->belongsTo('App\Models\TipoGasto','idTipoGasto');
    }


}
