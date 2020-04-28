<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cierre extends Model
{
    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda','idTienda');
    }

    public function tipoCierre()
    {
        return $this->belongsTo('App\Models\TipoCierre','idTipoCierre');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario','idUsuario');
    }

    protected $fillable = [
        'idTipoCierre','idTienda','idUsuario','fecha','billetes','monedas','total','comentarios'
    ];

    protected $casts = [
        'fecha' => 'datetime'
    ];
}
