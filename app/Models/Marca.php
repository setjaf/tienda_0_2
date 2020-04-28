<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda', 'idTienda');
    }

    public function productos()
    {
        return $this->hasMany('App\Models\Producto','idMarca');
    }

    protected $fillable = [
        'marca', 'idTienda','descripcion','imagen','activo'
    ];



}
