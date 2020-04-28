<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    public function productos()
    {
        return $this->belongsToMany('App\Models\Producto','producto_proveedors','idProveedor','idProducto')->withPivot('precio');
    }

    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda','idTienda');
    }

    public function pedidos()
    {
        return $this->hasMany('App\Models\PedidoProveedor','idProveedor');
    }

    protected $fillable = [
        'idTienda','nombre','saldo','activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];
}
