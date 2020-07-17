<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Cierre extends Model
{
    public function tienda()
    {
        return $this->belongsTo('App\Models\Tienda','idTienda');
    }

    public function tipoCierre()
    {
        return $this->belongsTo('App\Models\TipoCierre','idTipoCierre');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario','idUsuario');
    }

    public function getVentasAttribute()
    {
        return Venta::where('idTienda', $this->idTienda)
            ->whereBetween('fecha',[
                $this->created_at,
                $this->updated_at,
                ])
            ->get();
    }

    public function getGastosAttribute()
    {
        return Gasto::where('idTienda', $this->idTienda)
            ->whereBetween('fecha',[
                $this->cierreAnterior == null ? $this->tienda->created_at : $this->cierreAnterior->updated_at,
                $this->updated_at,
            ])
            ->get();
    }

    public function getEntradasAttribute()
    {
        return Entrada::where('idTienda', $this->idTienda)
            ->whereBetween('created_at',[
                $this->cierreAnterior == null ? $this->tienda->created_at : $this->cierreAnterior->updated_at,
                $this->updated_at,
            ])
            ->get();
    }

    public function getTotalVentasAttribute()
    {
        $v = Venta::where('idTienda', $this->idTienda)
        ->whereBetween('fecha',[
            $this->created_at,
            $this->updated_at,
            ])
        ->selectRaw('SUM(importe) as total')
        ->first()->total;
        return $v == null ? 0 : $v;
    }

    public function getTotalGastosAttribute()
    {
        $t = Gasto::where('idTienda', $this->idTienda)
        ->whereBetween('fecha',[
            $this->cierreAnterior == null ? $this->tienda->created_at : $this->cierreAnterior->updated_at,
            $this->updated_at,
            ])
        ->selectRaw('SUM(importe) as total')
        ->first()->total;
        return $t == null ? 0 : $t;
    }

    public function getTotalEntradasAttribute()
    {
        $t = Entrada::where('idTienda', $this->idTienda)
        ->whereBetween('created_at',[
            $this->cierreAnterior == null ? $this->tienda->created_at : $this->cierreAnterior->updated_at,
            $this->updated_at,
            ])
        ->selectRaw('SUM(total) as total')
        ->first()->total;
        return $t == null ? 0 : $t;
    }

    public function getCierreAnteriorAttribute()
    {
        return Cierre::where([
            ['idTienda', $this->idTienda],
            ['fecha','<', $this->created_at]
        ])->first();
    }

    public function getTotalDineroAnteriorAttribute()
    {
        return $this->cierreAnterior == null? 0 : $this->cierreAnterior->total;
    }

    public function getTotalDineroEsperadoAttribute()
    {
        return $this->totalDineroAnterior + $this->totalVentas - $this->totalGastos - $this->totalEntradas;
    }

    protected $fillable = [
        'idTipoCierre','idTienda','idUsuario','fecha','billetes','monedas','total','comentarios'
    ];

    protected $casts = [
        'fecha' => 'datetime'
    ];
}
