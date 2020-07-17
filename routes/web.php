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
    if(session()->has('idTienda'))
        return redirect()->route('tienda');
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
Route::post('/tienda/empleados','Tienda\TiendaController@showEmpleadosAsistencia')->name('tienda.showEmpleados');
Route::post('/tienda/empleados/asistencia','Tienda\TiendaController@empleadosAsistencia')->name('tienda.empleados.asistencia');
Route::get('/tienda/login', 'Tienda\TiendaController@showLogin')->name('tienda.showLogin');
Route::post('/tienda/login', 'Tienda\TiendaController@login')->name('tienda.login');

Route::get('/tienda/stock', 'Tienda\StockController@showStock')->name('tienda.stock');
Route::get('/tienda/stock/cargar/catalogo', 'Tienda\StockController@showCargaCatalogoStock')->name('tienda.stock.cargar.catalogo');
Route::post('/tienda/stock/cargar/catalogo', 'Tienda\StockController@cargaCatalogoStock')->name('tienda.stock.cargar.catalogo.guardar');
Route::post('/tienda/stock', 'Tienda\StockController@showStockFetch')->name('tienda.stock.fetch');
Route::post('/tienda/stock/buscar', 'Tienda\StockController@showStockBuscar')->name('tienda.stock.buscar');
Route::get('/tienda/stock/nuevo', 'Tienda\StockController@showNuevo')->name('stock.showNuevo');
Route::post('/tienda/stock/nuevo', 'Tienda\StockController@nuevo')->name('stock.nuevo');
Route::get('/tienda/stock/editar/{id}', 'Tienda\StockController@showEditar')->where('id','[0-9]+')->name('stock.showEditar');
Route::post('/tienda/stock/editar/{id}', 'Tienda\StockController@editar')->where('id','[0-9]+')->name('stock.editar');
Route::get('/tienda/stock/marcas', 'Tienda\StockController@showMarcas')->name('stock.showMarcas');
Route::post('/tienda/stock/marcas/nueva', 'Tienda\StockController@nuevaMarca')->name('stock.nuevaMarca');
Route::post('/tienda/stock/marcas/editar/{id}', 'Tienda\StockController@editarMarca')->where('id','[0-9]+')->name('stock.editarMarca');
Route::post('/tienda/stock/marcas/eliminar/{id}', 'Tienda\StockController@eliminarMarca')->where('id','[0-9]+')->name('stock.eliminarMarca');
Route::get('/tienda/stock/categorias', 'Tienda\StockController@showCategorias')->name('stock.showCategorias');
Route::post('/tienda/stock/categorias/nueva', 'Tienda\StockController@nuevaCategoria')->name('stock.nuevaCategoria');
Route::post('/tienda/stock/categorias/fetch', 'Tienda\StockController@showCategoriasProductos')->name('stock.showCategoriasProductos');
Route::post('/tienda/stock/categorias/asociar', 'Tienda\StockController@categoriaAsociarProductos')->name('stock.categoriaAsociarProductos');
Route::post('/tienda/stock/categorias/editar/{id}', 'Tienda\StockController@editarCategoria')->where('id','[0-9]+')->name('stock.editarCategoria');
Route::post('/tienda/stock/categorias/eliminar/{id}', 'Tienda\StockController@eliminarCategoria')->where('id','[0-9]+')->name('stock.eliminarCategoria');
Route::get('/tienda/stock/entradas', 'Tienda\StockController@showEntradas')->name('stock.showEntradas');
Route::get('/tienda/stock/entradas/nueva', 'Tienda\StockController@showNuevaEntrada')->name('stock.showNuevaEntrada');
Route::post('/tienda/stock/entradas/nueva', 'Tienda\StockController@nuevaEntrada')->name('stock.nuevaEntrada');
Route::post('/tienda/stock/entradas/nueva/fetchProductos', 'Tienda\StockController@entradaFetchProductos')->name('stock.entradaFetchProductos');
Route::get('/tienda/stock/entradas/editar/{id}', 'Tienda\StockController@showEntrada')->where('id','[0-9]+')->name('stock.showEntrada');
Route::post('/tienda/stock/entradas/editar/{id}', 'Tienda\StockController@editarEntrada')->where('id','[0-9]+')->name('stock.editarEntrada');
Route::get('/tienda/stock/proveedores/{id}', 'Tienda\StockController@showProveedores')->where('id','[0-9]+')->name('stock.showProveedores');
Route::post('/tienda/stock/proveedores/{id}', 'Tienda\StockController@editarPrecioProveedores')->where('id','[0-9]+')->name('stock.editarPrecioProveedores');

Route::get('/tienda/proveedores', 'Tienda\ProveedoresController@showProveedores')->name('proveedores.show');
Route::post('/tienda/proveedores/nuevo', 'Tienda\ProveedoresController@nuevoProveedor')->name('proveedores.nuevo');
Route::post('/tienda/proveedores/fetch', 'Tienda\ProveedoresController@showProveedoresProductos')->name('proveedores.showProveedoresProductos');
Route::post('/tienda/proveedores/asociar', 'Tienda\ProveedoresController@proveedorAsociarProductos')->name('proveedores.asociarProductos');
Route::post('/tienda/proveedores/editar/{id}', 'Tienda\ProveedoresController@editarProveedor')->where('id','[0-9]+')->name('proveedores.editar');

Route::get('/tienda/caja', 'Tienda\CajaController@showCaja')->name('caja');
Route::post('/tienda/caja/buscar', 'Tienda\CajaController@fetchProductosJSON')->name('caja.buscar');
Route::post('/tienda/caja/venta/finalizar', 'Tienda\CajaController@finalizarVenta')->name('caja.venta.finalizar');
Route::post('/tienda/caja/cierre/usuario', 'Tienda\CajaController@cierreCajaUsuario')->name('caja.cierre.usuario');
Route::get('/tienda/caja/ventas', 'Tienda\CajaController@showVentas')->name('caja.showVentas');
Route::get('/tienda/caja/ventas/{id}', 'Tienda\CajaController@showVenta')->where('id','[0-9]+')->name('caja.showVenta');

Route::get('/tienda/admin', 'Tienda\AdminController@showAdmin')->name('tienda.admin');
Route::get('/tienda/admin/empleados', 'Tienda\AdminController@showEmpleados')->name('tienda.admin.empleados');
Route::post('/tienda/admin/empleados/fetch', 'Tienda\AdminController@fetchEmpleados')->name('tienda.admin.empleados.fetch');
Route::post('/tienda/admin/empleados/asociar', 'Tienda\AdminController@tiendaAsociarEmpleados')->name('tienda.admin.empleados.asociar');
Route::get('/tienda/admin/empleados/{id}', 'Tienda\AdminController@showEmpleado')->where('id','[0-9]+')->name('tienda.admin.empleados.ver');
Route::post('/tienda/admin/empleados/{id}', 'Tienda\AdminController@editarEmpleado')->where('id','[0-9]+')->name('tienda.admin.empleados.editar');
Route::post('/tienda/admin/empleados/{id}/asistencias', 'Tienda\AdminController@showEmpleadoAsistencias')->where('id','[0-9]+')->name('tienda.admin.empleados.ver.asistencias');
Route::get('/tienda/admin/gastos', 'Tienda\AdminController@showGastos')->name('tienda.admin.gastos');
Route::post('/tienda/admin/gastos', 'Tienda\AdminController@showGastosFetch')->name('tienda.admin.gastos.ver');
Route::post('/tienda/admin/gastos/nuevo', 'Tienda\AdminController@nuevoGasto')->name('tienda.admin.gastos.nuevo');
Route::post('/tienda/admin/gastos/{id}', 'Tienda\AdminController@editarGasto')->name('tienda.admin.gastos.editar');
Route::get('/tienda/admin/gastos/tipos', 'Tienda\AdminController@showtiposGasto')->name('tienda.admin.gastos.tipos');
Route::post('/tienda/admin/gastos/tipos', 'Tienda\AdminController@nuevoTipoGasto')->name('tienda.admin.gastos.tipos.nuevo');
Route::post('/tienda/admin/gastos/tipos/{id}', 'Tienda\AdminController@editarTipoGasto')->where('id','[0-9]+')->name('tienda.admin.gastos.tipos.editar');
Route::get('/tienda/admin/cierres', 'Tienda\AdminController@showCierres')->name('tienda.admin.cierres');
Route::post('/tienda/admin/cierres', 'Tienda\AdminController@showCierresFetch')->name('tienda.admin.cierres');
Route::get('/tienda/admin/cierres/{id}', 'Tienda\AdminController@showCierre')->where('id','[0-9]+')->name('tienda.admin.cierres.ver');
Route::get('/tienda/admin/cierres/{id}/venta/{idVenta}', 'Tienda\AdminController@showCierreVenta')->where('id','[0-9]+')->where('idVenta','[0-9]+')->name('tienda.admin.cierres.ver.venta');
Route::get('/tienda/admin/cierres/{id}/entrada/{idEntrada}', 'Tienda\AdminController@showCierreEntrada')->where('id','[0-9]+')->where('idEntrada','[0-9]+')->name('tienda.admin.cierres.ver.entrada');
