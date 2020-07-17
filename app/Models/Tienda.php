<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    public function administrador()
    {
        return $this->belongsTo('App\Models\Usuario','idUsuario');
    }

    public function empleados()
    {
        return $this->belongsToMany('App\Models\Usuario','empleados','idTienda','idUsuario')->withPivot('id','formaPago','sueldo','inicio');
    }

    public function asistencias()
    {
        return $this->belongsToMany('App\Models\Empleado','asistencias','idTienda','idEmpleado')->withPivot('entrada','salida');
    }

    public function empleadosSalida()
    {
        $hoy = (new DateTime('NOW'))->format('d-m-Y');

        return $this->empleados->filter(function ($empleado, $key) use ($hoy)
        {
            return Asistencia::where([
                ['idEmpleado', $empleado->pivot->id],
                ['entrada','>=',new DateTime($hoy)],
                ['salida',null]
            ])->exists();
        });
    }

    public function empleadosEntrada()
    {
        $hoy = (new DateTime('NOW'))->format('d-m-Y');

        return $this->empleados->filter(function ($empleado, $key) use ($hoy)
        {
            return !Asistencia::where([
                ['idEmpleado', $empleado->pivot->id],
                ['entrada','>=',new DateTime($hoy)]
            ])->exists();
        });
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

    public function tiposGasto()
    {
        return $this->hasMany('App\Models\TipoGasto','idTienda');
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
