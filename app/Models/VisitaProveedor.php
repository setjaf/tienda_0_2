<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitaProveedor extends Model
{
    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda','idTienda');
    }

    public function pedido()
    {
        return $this->belongsTo('App\Models\Pedido','idPedido');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario','idUsuario');
    }

    public function proveedor()
    {
        return $this->belongsTo('App\Models\Proveedor','idProveedor');
    }

    public function entrada()
    {
        return $this->belongsTo('App\Models\Entrada','idEntrada');
    }

    protected $fillable = [
        'idTienda','idUsuario','idProveedor','idPedido','idEntrada','fecha','importe','pagado'
    ];

    protected $casts = [
        'fecha'=>'datetime',
        'pagado'=>'boolean'
    ];

}
