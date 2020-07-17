<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CatMarca;
use App\Models\CatProducto;
use App\Models\Entrada;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    //
    /**
     * Creamos una instancia de controller y se colocan los middlewares que se van a utilizar para este controlador
     *
     */

    public function __construct(){
        // Revisa si hay un usuario loggeado
        $this->middleware('auth');
        // Comprueba si el correo del usuario actual está verificado
        $this->middleware('verified');
        // Verifica que una tienda esté iniciada, si no está iniciada te regresa a '/tiendas'
        $this->middleware('tiendaOpen');
        // Verifica que el usuario sea empleado o administrador de la tienda
        $this->middleware('belongsToTienda');
    }

    public function showStock(){

        $tienda = Tienda::find(session('idTienda'));
        $productos = Producto::where([
            ['idTienda',$tienda->id],
            ['activo',true]
        ])
        ->orderByRaw('disponible - deseado ASC')
        ->paginate(10);

        return view('tienda.stock.inicio')
            ->with('tiendaLog',$tienda)
            ->with('stock',$productos);
    }

    public function showCargaCatalogoStock()
    {
        return view('tienda.stock.catalogo')
            ->with('productos',CatProducto::all());
    }

    public function cargaCatalogoStock(Request $request)
    {
        $data = $request->all();
        // dd(array_key_exists('75004699',$data));
        // dd($data);
        $marcas = CatMarca::all();
        foreach ($marcas as $marca) {

            $nuevaMarca  = Marca::create([
                'idTienda' => session('idTienda'),
                'marca' => $marca->marca,
                'descripcion' => $marca->descripcion,
                'imagen' => $marca->imagen,
                'activo' => true,
            ]);

            $productos = CatProducto::where('idMarca',$marca->id)->get();

            foreach ($productos as $producto) {
                if(array_key_exists($producto->codigo,$data)){
                    $nuevoProducto = Producto::create([
                        'idTienda' => session('idTienda'),
                        'idMarca' => $nuevaMarca->id,
                        'codigo' => $producto->codigo,
                        'producto' => $producto->producto,
                        'unidadMedida' => $producto->unidadMedida,
                        'formaVenta' => $producto->formaVenta,
                        'tamano' => $producto->tamano,
                        'imagen' => $producto->imagen,
                        'disponible' => $data[$producto->codigo."-disponible"],
                        'deseado' => $data[$producto->codigo."-deseado"],
                    ]);
                }

            }
        }



        return redirect()->route('tienda.stock');
    }

    public function showStockFetch(Request $request){

        if($request->ajax()){
            $productos = Producto::where([
                ['idTienda',session('idTienda')],
                ['activo',true]
            ])
            ->orderByRaw('disponible - deseado ASC')
            ->paginate(10);

            return view('tienda.stock.productos')->with('stock',$productos)->render();
        }

    }

    public function showStockBuscar(Request $request){

        if ($request->ajax()) {
            $data = $request->all();

            if (!$request->has('buscar')) {
                $data = session('data');
            }else{
                session(['data'=>$data]);
            }

            $productos = Producto::where([
                ['idTienda',session('idTienda')],
                ['activo',true]
            ]);

            if (array_key_exists('codigo',$data)) {
                $productos = $productos->where('codigo',$data['codigo']);
            }

            if (array_key_exists('marca',$data)) {
                $productos = $productos->where('idMarca',$data['marca']);
            }

            $productos = $productos->where(function ($q) use ($data)
            {
                $q->orWhere('producto','LIKE',array_key_exists('nombre',$data)?"%{$data['nombre']}%":"%%");
            });

            if (array_key_exists('categorias',$data)) {
                $productos = $productos->whereHas('categorias', function($q) use ($data){
                    $q->whereIn('id',$data['categorias']);
                });
            }

            $productos = $productos->paginate(10);
            //dd($productos);
            return view('tienda.stock.productos')->with('stock',$productos)->render();

        }
    }

    public function showNuevo(){
        $tienda = Tienda::find(session('idTienda'));
        return view('tienda.stock.nuevo')
            ->with('tiendaLog',$tienda);
    }

    public function nuevo(Request $request){

        $data = $request->all();

        $this->productoValidator($data)->validate();
        //dd($data);
        $data['activo'] = !empty($data['activo']);
        $data['disponible'] = empty($data['disponible'])?0:$data['disponible'];
        $data['deseado'] = empty($data['deseado'])?0:$data['deseado'];
        $data['precioVenta'] = empty($data['precioVenta'])?0:$data['precioVenta'];
        $data = array_merge($data,['idTienda'=>session('idTienda')]);

        $producto = Producto::create($data);

        if($producto!=null){

            $producto->categorias()->sync(array_values(empty($data['categorias'])?[]:$data['categorias']));

            if (isset(request()->imagen)) {
                $filename = $producto->id.'.'.request()->imagen->getClientOriginalExtension();

                request()->imagen->move(public_path('img/productos'), $filename);

                $producto->imagen=$filename;

                $producto->save();
            }

            return redirect()->route('tienda.stock')->with('message',"El producto {$producto->producto} se ha creado correctamente.");
        }

        return back()->withInput($data)->with('messageError',true);
    }

    private function productoValidator($data)
    {
        return Validator::make($data,[
            'codigo' => 'required|max:13',
            'producto' => 'string|required',
            'formaVenta' => 'required',
            'idMarca'=>'required',
            'unidadMedida' => 'required',
            'tamano' => 'required_if:formaVenta,2',
            'activo'=>'nullable',
        ]);
    }

    public function showEditar($id){
        $tienda = Tienda::find(session('idTienda'));
        $producto = Producto::find($id);
        $categorias = Categoria::all();
        return view('tienda.stock.editar')
            ->with('tiendaLog',$tienda)
            ->with('producto',$producto)
            ->with('categorias',$categorias);
    }

    public function editar($id, Request $request){
        $data = $request->all();

        $this->productoValidator($data)->validate();

        $producto = Producto::find($id);

        $catChange = $producto->categorias()->sync(array_values(empty($data['categorias'])?[]:$data['categorias']));


        $producto->codigo = $data['codigo'];
        $producto->producto = $data['producto'];
        $producto->formaVenta = $data['formaVenta'];
        $producto->idMarca = $data['idMarca'];
        $producto->unidadMedida = $data['unidadMedida'];
        $producto->tamano = $data['tamano'];
        $producto->activo = !empty($data['activo']);
        $producto->deseado = $data['deseado'];
        // $producto->disponible = $data['disponible'];
        $producto->precioVenta = $data['precioVenta'];

        if (!empty($data["eliminarImagen"])) {
            $producto->imagen = 'default.jpg';
        }

        if (isset(request()->imagen)) {

            $filename = $producto->id.'_'.date('dmYhi').'.'.request()->imagen->getClientOriginalExtension();

            File::delete(public_path('img/productos').'/'.$producto->imagen);

            request()->imagen->move(public_path('img/productos'), $filename);

            $producto->imagen=$filename;
        }

        if($producto->isDirty() || isset(request()->imagen) || !empty($catChange['attached']) || !empty($catChange['detached']) || !empty($catChange['updated'])){
            if($producto->save()){
                return redirect()->route('stock.editar',$id)->with('message',"El producto {$producto->producto} se ha editado correctamente.");
            }else{
                return redirect()->route('stock.editar',$id)->with('messageError',"El producto {$producto->producto} no se ha editado correctamente, inténtalo de nuevo.");
            }
        }else{
            return redirect()->route('stock.editar',$id)->with('message',"La información que enviaste del producto {$producto->producto} es la misma.");
        }
    }

    public function showMarcas()
    {
        $tienda = Tienda::find(session('idTienda'));
        $marcas = Marca::where('idTienda',$tienda->id)->paginate(15);

        return view('tienda.stock.marcas.inicio')
            ->with('tiendaLog',$tienda)
            ->with('marcas',$marcas);
    }

    public function nuevaMarca(Request $request)
    {
        $data = $request->all();

        $this->marcaValidator($data)->validate();

        $data['activo'] = !empty($data['activo']);

        $data = array_merge($data,['idTienda'=>session('idTienda')]);

        $marca = Marca::create($data);

        if (isset(request()->imagen)) {
            $filename = $marca->id.'.'.request()->imagen->getClientOriginalExtension();

            request()->imagen->move(public_path('img/marcas'), $filename);

            $marca->imagen=$filename;

            $marca->save();
        }

        if($marca!=null){
            return redirect()->route('stock.showMarcas')->with('message',"La marca {$marca->marca} se ha creado correctamente.");
        }

        return back()->withInput($data)->with('messageError',true);
    }

    public function editarMarca($id, Request $request)
    {
        $data = $request->all();

        $this->marcaValidator($data)->validate();

        $data['activo'] = !empty($data['activo']);

        $marca = Marca::find($id);

        $marca->fill($data);

        if (!empty($data["eliminarImagen"])) {
            $marca->imagen = 'default.jpg';
        }

        if (isset(request()->imagen)) {

            $filename = $marca->id.'_'.date('dmYhi').'.'.request()->imagen->getClientOriginalExtension();

            File::delete(public_path('img/marcas').'/'.$marca->imagen);

            request()->imagen->move(public_path('img/marcas'), $filename);

            $marca->imagen=$filename;
        }

        if($marca->isDirty() || isset(request()->imagen)){
            if($marca->save()){
                return redirect()->route('stock.showMarcas')->with('message',"La marca {$marca->marca} se ha editado correctamente.");
            }else{
                return redirect()->route('stock.showMarcas')->with('messageError',"La marca {$marca->nombre} no se ha editado correctamente, inténtalo de nuevo.");
            }
        }else{
            return redirect()->route('stock.showMarcas')->with('message',"La información que enviaste de la marca {$marca->nombre} es la misma.");
        }
    }

    public function eliminarMarca($id, Request $request)
    {
        $marca = Marca::find($id);
        $marca->history()->forceDelete();
    }

    private function marcaValidator($data)
    {
        return Validator::make($data,[
            'marca' => 'required|string',
            'descripcion' => 'required|string'
        ]);
    }

    public function showCategorias()
    {
        $tienda = Tienda::find(session('idTienda'));
        $categorias = Categoria::where('idTienda',$tienda->id)->paginate(15);

        return view('tienda.stock.categorias.inicio')
            ->with('tiendaLog',$tienda)
            ->with('categorias',$categorias);
    }

    public function showCategoriasProductos(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $productos = Producto::where('idTienda',session('idTienda'))->get();
            $productos = $productos->sortByDesc(function($producto,$key) use ($data){
                return $producto->proveedores->contains($data['categoria']);
            });
            // ->whereDoesntHave('categorias', function ($q) use ($data){
            //     $q->where('id',$data['categoria']);
            // })->get();

            //dd($productos);

            return view('tienda.stock.categorias.productos')
                ->with('productos',$productos)
                ->with('categoria',$data['categoria'])
                ->render();
        }

    }

    public function categoriaAsociarProductos(Request $request){
        $data = $request->all();

        $categorias = Categoria::find($data['categoria']);

        $categorias->productos()->sync($data['productos']);

    }

    public function nuevaCategoria(Request $request)
    {
        $data = $request->all();

        $this->categoriaValidator($data)->validate();

        $data['activo'] = !empty($data['activo']);

        $data = array_merge($data,['idTienda'=>session('idTienda')]);

        $categoria = Categoria::create($data);

        if($categoria!=null){
            return redirect()->route('stock.showCategorias')->with('message',"La categoría {$categoria->categoria} se ha creado correctamente.");
        }

        return back()->withInput($data)->with('messageError',true);
    }

    public function editarCategoria($id, Request $request)
    {
        $data = $request->all();

        $this->categoriaValidator($data)->validate();

        $data['activo'] = !empty($data['activo']);

        $categoria = Categoria::find($id);

        $categoria->fill($data);

        if($categoria->isDirty() || isset(request()->imagen)){
            if($categoria->save()){
                return redirect()->route('stock.showCategorias')->with('message',"La categoria {$categoria->categoria} se ha editado correctamente.");
            }else{
                return redirect()->route('stock.showCategorias')->with('messageError',"La categoria {$categoria->categoria} no se ha editado correctamente, inténtalo de nuevo.");
            }
        }else{
            return redirect()->route('stock.showCategorias')->with('message',"La información que enviaste de la categoria {$categoria->categoria} es la misma.");
        }
    }

    public function eliminarCategoria($id, Request $request)
    {
        $marca = Marca::find($id);
        $marca->history()->forceDelete();
    }

    private function categoriaValidator($data)
    {
        return Validator::make($data,[
            'categoria' => 'required|string',
            'descripcion' => 'required|string',
            'color' => 'string|max:7|min:7|nullable'
        ]);
    }

    public function showEntradas()
    {
        $tienda = Tienda::find(session('idTienda'));
        $entradas = Entrada::where('idTienda',session('idTienda'))->paginate(10);
        //dd($entradas);
        return view('tienda.stock.entradas.inicio')
            ->with('tiendaLog',$tienda)
            ->with('entradas',$entradas);
    }

    public function showEntradasFetch(Request $request){

        if($request->ajax()){
            $entradas = Entrada::where('idTienda',session('idTienda'))->paginate(10);

            return view('tienda.stock.entradas.entradas')->with('stock',$entradas)->render();
        }

    }

    public function showEntradasBuscar(Request $request){

        if ($request->ajax()) {
            $data = $request->all();

            if (!$request->has('buscar')) {
                $data = session('data');
            }else{
                session(['data'=>$data]);
            }

            $productos = Producto::where('idTienda',session('idTienda'));

            if (array_key_exists('codigo',$data)) {
                $productos = $productos->where('codigo',$data['codigo']);
            }

            if (array_key_exists('marca',$data)) {
                $productos = $productos->where('idMarca',$data['marca']);
            }

            $productos = $productos->where(function ($q) use ($data)
            {
                $q->orWhere('producto','LIKE',array_key_exists('nombre',$data)?"%{$data['nombre']}%":"%%");
            });

            if (array_key_exists('categorias',$data)) {
                $productos = $productos->whereHas('categorias', function($q) use ($data){
                    $q->whereIn('id',$data['categorias']);
                });
            }

            $productos = $productos->paginate(10);
            //dd($productos);
            return view('tienda.stock.productos')->with('stock',$productos)->render();

        }
    }

    public function showNuevaEntrada()
    {
        $tienda = Tienda::find(session('idTienda'));
        return view('tienda.stock.entradas.nueva')
            ->with('tiendaLog',$tienda);
    }

    public function nuevaEntrada(Request $request)
    {
        $data = $request->all();

        if (array_key_exists('productosObj',$data)) {

            //dd($data);
            $entrada = Entrada::create([
                'idTienda'=>session('idTienda'),
                'idUsuario'=>Auth::user()->id,
                'total'=>$data['total'],
            ]);

            if($entrada != null){
                $resultadoSync = $entrada->productos()->sync($data['productosObj']);
            }

            foreach ($data['preciosNuevos'] as $id => $datos ) {
                $producto = Producto::find($id);
                $producto->precioVenta = $datos['precioventanuevo'];
                $producto->disponible += $data['productosObj'][$id]['unidades'];
                $producto->save();
            }

            return response()->json([
                'ok'=>true,
                'redirectTo'=>route('stock.showEntradas'),
                'mensaje' => 'La entrada se guardó correctamente',
            ]);

        }else{
            return response()->json([
                'ok'=>false,
                'mensaje'=>'No has enviado la información necesaria para guardar la nueva entrada.',
                'redirectTo'=>null,
            ]);
        }
    }

    public function entradaFetchProductos(Request $request)
    {
        if ($request->ajax()) {

            $data = $request->all();
            $productos = Producto::where('idTienda',session('idTienda'))->whereNotIn('id',array_key_exists('productos',$data)?$data['productos']:[])->get();

            return view('tienda.stock.entradas.productos')
                ->with('productos',$productos)
                ->render();
        }
    }

    public function showEntrada($id, Request $request)
    {
        $tienda = Tienda::find(session('idTienda'));
        $entrada = Entrada::find($id);

        return view('tienda.stock.entradas.entrada')
            ->with('tiendaLog',$tienda)
            ->with('entrada',$entrada);
    }

    public function editarEntrada($id, Request $request)
    {
        $data = $request->all();

        if (array_key_exists('productosObj',$data)) {

            $entrada = Entrada::find($id);

            $productos = $entrada->productos()->get()->toArray();

            foreach ($productos as $producto) {
                if(array_key_exists($producto['id'],$data['productosObj'])){
                    $nuevoProducto = Producto::find($producto['id']);
                    if ($producto['pivot']['unidades'] != $data['productosObj'][$producto['id']]['unidades']) {
                        $nuevoProducto->disponible += $data['productosObj'][$producto['id']]['unidades'] - $producto['pivot']['unidades'];
                    }
                    $nuevoProducto->precioVenta = $data['productosObj'][$producto['id']]['precioventa'];
                    $nuevoProducto->save();
                }else{
                    $nuevoProducto = Producto::find($producto['id']);
                    $nuevoProducto->disponible -= $producto['pivot']['unidades'];
                    $nuevoProducto->precioVenta = $producto['precioVenta'];
                    $nuevoProducto->save();
                }
            }

            $resultadoSync = $entrada->productos()->sync($data['productosObj']);
            $entrada->total = $data['total'];
            $entrada->save();
            //dd($resultadoSync);

            foreach ($data['preciosNuevos'] as $id => $datos ) {
                $producto = Producto::find($id);
                $producto->precioVenta = $datos['precioventanuevo'];
                $producto->save();
            }

            return response()->json([
                'ok'=>true,
                'redirectTo'=>route('stock.showEntradas'),
                'mensaje' => 'La entrada se guardó correctamente',
            ]);

        }else{
            return response()->json([
                'ok'=>false,
                'mensaje'=>'No has enviado la información necesaria para guardar la nueva entrada.',
                'redirectTo'=>null,
            ]);
        }
    }

    public function showProveedores($id){
        $tienda = Tienda::find(session('idTienda'));
        $producto = Producto::find($id);
        return view('tienda.stock.proveedores.inicio')
            ->with('tiendaLog',$tienda)
            ->with('producto',$producto);
    }

    public function editarPrecioProveedores($id, Request $request){
        $data = $request->all();

        $this->productoValidator($data)->validate();

        $producto = Producto::find($id);

        $catChange = $producto->categorias()->sync(array_values(empty($data['categorias'])?[]:$data['categorias']));


        $producto->codigo = $data['codigo'];
        $producto->producto = $data['producto'];
        $producto->formaVenta = $data['formaVenta'];
        $producto->idMarca = $data['idMarca'];
        $producto->unidadMedida = $data['unidadMedida'];
        $producto->tamano = $data['tamano'];
        $producto->activo = !empty($data['activo']);
        $producto->deseado = $data['deseado'];
        $producto->disponible = $data['disponible'];
        $producto->precioVenta = $data['precioVenta'];

        if (!empty($data["eliminarImagen"])) {
            $producto->imagen = 'default.jpg';
        }

        if (isset(request()->imagen)) {

            $filename = $producto->id.'_'.date('dmYhi').'.'.request()->imagen->getClientOriginalExtension();

            File::delete(public_path('img/productos').'/'.$producto->imagen);

            request()->imagen->move(public_path('img/productos'), $filename);

            $producto->imagen=$filename;
        }

        if($producto->isDirty() || isset(request()->imagen) || !empty($catChange['attached']) || !empty($catChange['detached']) || !empty($catChange['updated'])){
            if($producto->save()){
                return redirect()->route('stock.editar',$id)->with('message',"El producto {$producto->producto} se ha editado correctamente.");
            }else{
                return redirect()->route('stock.editar',$id)->with('messageError',"El producto {$producto->producto} no se ha editado correctamente, inténtalo de nuevo.");
            }
        }else{
            return redirect()->route('stock.editar',$id)->with('message',"La información que enviaste del producto {$producto->producto} es la misma.");
        }
    }
}
