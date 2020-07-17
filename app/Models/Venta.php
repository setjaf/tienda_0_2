<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda','idTienda');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario','idUsuario');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Models\Producto','producto_ventas','idVenta','idProducto')->withPivot('unidades','precioFinal','precioVenta','subtotal');
    }

    protected $fillable = [
        'idTienda','idUsuario','importe','fecha', 'comentarios'
    ];

    protected $casts = [
        'fecha'=>'datetime'
    ];
}
