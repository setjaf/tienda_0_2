<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda','idTienda');
    }

    public function productos(){
        return $this->belongsToMany('App\Models\Producto', 'producto_categorias', 'idCategoria','idProducto');
    }

    protected $casts = [
        'activo' => 'boolean'
    ];

    protected $fillable = [
        'idTienda', 'categoria', 'descripcion', 'color', 'activo'
    ];

}
