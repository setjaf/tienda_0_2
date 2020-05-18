<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/tiendas', 'Tienda\TiendasController@showTiendas')->name('tiendas');
Route::get('/tiendas/nueva','Tienda\TiendasController@showNueva')->name('tiendas.showNueva');
Route::post('/tiendas/nueva','Tienda\TiendasController@nueva')->name('tiendas.nueva');
Route::post('/tienda/cerrar', 'Tienda\TiendaController@cerrar')->name('tienda.cerrar');
Route::post('/tienda', 'Tienda\TiendaController@entrar')->name('tienda.entrar');
Route::get('/tienda', 'Tienda\TiendaController@showTienda')->name('tienda');
Route::get('/tienda/login', 'Tienda\TiendaController@showLogin')->name('tienda.showLogin');
Route::post('/tienda/login', 'Tienda\TiendaController@login')->name('tienda.login');
Route::get('/tienda/stock', 'Tienda\StockController@showStock')->name('stock');
Route::get('/tienda/stock/nuevo', 'Tienda\StockController@showNuevo')->name('stock.showNuevo');
Route::post('/tienda/stock/nuevo', 'Tienda\StockController@nuevo')->name('stock.nuevo');
Route::get('/tienda/stock/editar/{id}', 'Tienda\StockController@showEditar')->where('id','[0-9]+')->name('stock.showEditar');
Route::post('/tienda/stock/editar/{id}', 'Tienda\StockController@editar')->where('id','[0-9]+')->name('stock.editar');
Route::get('/tienda/stock/marcas', 'Tienda\StockController@showMarcas')->name('stock.showMarcas');
Route::post('/tienda/stock/marcas/nueva', 'Tienda\StockController@nuevaMarca')->name('stock.nuevaMarca');
Route::post('/tienda/stock/marcas/editar/{id}', 'Tienda\StockController@editarMarca')->where('id','[0-9]+')->name('stock.editarMarca');
Route::post('/tienda/stock/marcas/eliminar/{id}', 'Tienda\StockController@eliminarMarca')->where('id','[0-9]+')->name('stock.eliminarMarca');
