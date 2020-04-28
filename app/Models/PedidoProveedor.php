<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PedidoProveedor extends Model
{
    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario','idUsuario');
    }

    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda','idTienda');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedor','idProveedor');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Models\Producto','productos_pedidos','idPedido','idProducto')->withPivot('cantidad');
    }

    protected $fillable = [
        'idTienda','idUsuario','idProveedor'
    ];

    protected $casts = [
        'fechaPedido'=>'datetime',
        'atendido'=>'boolean'
    ];
}
