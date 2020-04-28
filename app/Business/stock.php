<?php

namespace App\Business;

use App\Models\Producto;

class Stock {

    public function getProductos()
    {
        return Producto::all();
    }

    public function addProducto($data)
    {
        return Producto::create($data);
    }

}
