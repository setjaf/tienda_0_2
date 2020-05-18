<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    public function administrador()
    {
        return $this->belongsTo('App\Models\Usuario','idUsuario');
    }

    public function empleados()
    {
        return $this->belongsToMany('App\Models\Usuario','empleados','idTienda','idUsuario')->withPivot('formaPago','sueldo','inicio');
    }

    public function categorias()
    {
        return $this->hasMany('App\Models\Categoria','idTienda');
    }

    public function productos()
    {
        return $this->hasMany('App\Models\Producto','idTienda');
    }

    public function tipoGastos()
    {
        return $this->hasMany('App\Models\TipoGasto','idTienda');
    }

    public function gastos()
    {
        return $this->hasMany('App\Models\Gasto','idTienda');
    }

    public function marcas()
    {
        return $this->hasMany('App\Models\Marca','idTienda');
    }

    public function pedidosProveedor()
    {
        return $this->hasMany('App\Models\PedidoProveedor','idTienda');
    }

    public function cierres()
    {
        return $this->hasMany('App\Models\Cierre','idTienda');
    }

    protected $fillable = [
        'idUsuario', 'nombre', 'calle', 'numero', 'cp', 'balance', 'imagen', 'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

}
