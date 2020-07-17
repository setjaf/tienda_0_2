<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedoresController extends Controller
{
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

    public function showProveedores()
    {
        $tienda = Tienda::find(session('idTienda'));
        $proveedores = Proveedor::where('idTienda',session('idTienda'))->paginate(15);

        return view('tienda.proveedores.inicio')
            ->with('tiendaLog',$tienda)
            ->with('proveedores',$proveedores);
    }

    public function showProveedoresProductos(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $productos = Producto::where('idTienda',session('idTienda'))->get();
            $productos = $productos->sortByDesc(function($producto,$key) use ($data){
                return $producto->proveedores->contains($data['proveedor']);
            });

            // ->whereDoesntHave('proveedores', function ($q) use ($data){
            //     $q->where('id',$data['proveedor']);
            // })->get();

            //dd($productos);

            return view('tienda.proveedores.productos')
                ->with('productos',$productos)
                ->with('proveedor',$data['proveedor'])
                ->render();
        }

    }

    public function proveedorAsociarProductos(Request $request){
        if ($request->ajax()) {

            $data = $request->all();

            $proveedor = Proveedor::find($data['proveedor']);

            $proveedor->productos()->sync($data['productos']);
        }

    }

    public function nuevoProveedor(Request $request)
    {
        $data = $request->all();

        $this->proveedorValidator($data)->validate();

        $data['activo'] = !empty($data['activo']);

        $data = array_merge($data,['idTienda'=>session('idTienda')]);

        $proveedor = Proveedor::create($data);

        if($proveedor!=null){
            return redirect()->route('proveedores.show')->with('message',"La categoría {$proveedor->nombre} se ha creado correctamente.");
        }

        return back()->withInput($data)->with('messageError',true);
    }

    public function editarProveedor($id, Request $request)
    {
        $data = $request->all();

        $this->proveedorValidator($data)->validate();

        $data['activo'] = !empty($data['activo']);

        $proveedor = Proveedor::find($id);

        $proveedor->fill($data);

        if($proveedor->isDirty() || isset(request()->imagen)){
            if($proveedor->save()){
                return redirect()->route('proveedores.show')->with('message',"El proveedor {$proveedor->nombre} se ha editado correctamente.");
            }else{
                return redirect()->route('proveedores.show')->with('messageError',"El proveedor {$proveedor->nombre} no se ha editado correctamente, inténtalo de nuevo.");
            }
        }else{
            return redirect()->route('proveedores.show')->with('message',"La información que enviaste del proveedor {$proveedor->nombre} es la misma.");
        }
    }

    public function eliminarProveedor($id, Request $request)
    {
        $marca = Marca::find($id);
        $marca->history()->forceDelete();
    }

    private function proveedorValidator($data)
    {
        return Validator::make($data,[
            'nombre' => 'required|string',
            'saldo' => 'required|numeric'
        ]);
    }
}
