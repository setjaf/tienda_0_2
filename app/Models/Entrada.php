<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{

    public function proveedorVisitas()
    {
        return $this->hasMany('App\Models\ProveedorVisitas', 'idEntrada');
    }

    public function proveedores()
    {
        return $this->hasManyThrough('App\Models\Proveedor','App\Models\ProveedorVisita','idEntrada','idProveedor');
    }

    public function productos()
    {
        return $this->belongsToMany('App\Models\Producto','producto_entradas','idEntrada','idProducto')->withPivot(['unidades','precioCompra','precioVenta','precioVentaAnterior']);
    }

    protected $casts = [
        'fecha'=>'datetime'
    ];


    protected $fillable = [
        'idTienda','idUsuario','total','fecha'
    ];
}
