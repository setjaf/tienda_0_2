<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Tienda;
use Illuminate\Http\Request;
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
        $this->middleware('auth',['except'=>['cerar','showLogin']]);
        // Comprueba si el correo del usuario actual está verificado
        $this->middleware('verified',['except'=>['login','showLogin']]);
        // Verifica que una tienda esté iniciada, si no está iniciada te regresa a '/tiendas'
        $this->middleware('tiendaOpen',['except'=>['entrar']]);
    }

    public function showStock(){

        $tienda = Tienda::find(session('idTienda'));
        $productos = Producto::where('idTienda',$tienda->id)->paginate(15);

        return view('tienda.stock.inicio')
            ->with('tiendaLog',$tienda)
            ->with('stock',$productos);
    }

    public function showNuevo(){
        $tienda = Tienda::find(session('idTienda'));
        return view('tienda.stock.nuevo')
            ->with('tiendaLog',$tienda);
    }

    public function nuevo(Request $request){

        $data = $request->all();

        $this->productoValidator($data)->validate();

        $data['activo'] = !empty($data['activo']);

        $data = array_merge($data,['idTienda'=>session('idTienda')]);

        $producto = Producto::create($data);

        if (isset(request()->imagen)) {
            $filename = $producto->id.'.'.request()->imagen->getClientOriginalExtension();

            request()->imagen->move(public_path('img/productos'), $filename);

            $producto->imagen=$filename;

            $producto->save();
        }

        if($producto!=null){
            return redirect()->route('stock')->with('message',"El producto {$producto->producto} se ha creado correctamente.");
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
        return view('tienda.stock.editar')
            ->with('tiendaLog',$tienda)
            ->with('producto',$producto);
    }

    public function editar($id, Request $request){
        $data = $request->all();

        $this->productoValidator($data)->validate();

        $producto = Producto::find($id);

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

        if($producto->isDirty() || isset(request()->imagen)){
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

    public function nuevaCategoria(Request $request)
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

    public function editarCategoria($id, Request $request)
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

    public function eliminarCategoria($id, Request $request)
    {
        $marca = Marca::find($id);
        $marca->history()->forceDelete();
    }


}
