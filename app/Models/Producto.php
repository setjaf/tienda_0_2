<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda', 'idTienda');
    }

    public function marca()
    {
        return $this->belongsTo('App\Models\Marca','idMarca');
    }

    public function ventas()
    {
        return $this->belongsToMany('App\Models\Venta','producto_ventas','idVenta','idProducto');
    }

    public function proveedores()
    {
        return $this->belongsToMany('App\Models\Proveedor','producto_proveedors','idProducto','idProveedor')->withPivot('precio');
    }

    protected $fillable = [
        'idTienda','idMarca','producto','unidadMedida','formaVenta','tamano','disponible','deseado','precioVenta','imagen','activo'
    ];

    protected $casts = [
        'activo'=>'boolean'
    ];
}
