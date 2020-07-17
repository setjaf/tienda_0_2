<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Cierre;
use App\Models\Producto;
use App\Models\Tienda;
use App\Models\Venta;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;

class CajaController extends Controller
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

    public function showCaja(){
        $tienda = Tienda::find(session('idTienda'));
        if (!session()->has('idCierre')) {
            $cierre = Cierre::create([
                'idTipoCierre' => 1,
                'idTienda' => session('idTienda'),
                'idUsuario' => Auth::user()->id,
                'fecha' => new DateTime('NOW'),
                'billetes' => 0,
                'monedas' => 0,
                'total' => 0
            ]);
            session(['fechaCajaAbierta'=>new  DateTime('NOW')]);
            session(['idCierre' => $cierre->id]);
            session(['erroresCaja'=>[]]);
        }

        return view('tienda.caja.inicio')
            ->with('tiendaLog',$tienda);
    }

    public function fetchProductosJSON(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $palabras = explode(" ", $data["valorBuscar"]);
            $valorBuscar = implode("%",$palabras);
            $productos = Producto::where([
                ['idTienda',session('idTienda')],
                ['activo',true],
                ['codigo',$data["valorBuscar"]]
            ])
            ->orWhere([
                ['idTienda',session('idTienda')],
                ['activo',true],
                ['producto','like','%'.$valorBuscar.'%']
            ])->get();

            return response()->json($productos);
        }
    }

    public function finalizarVenta(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            $forzarError = false;

            if (array_key_exists('productos',$data) && $this->verificarStock($data['productos']) == null && !$forzarError){

                $venta = Venta::create([
                    "idTienda" => session('idTienda'),
                    "idUsuario" => Auth::user()->id,
                    "importe" => $data['total'],
                    "fecha" => new DateTime('NOW'),
                    "comentarios" => $data['comentarios'],
                ]);

                if ($venta != null) {
                    $venta->productos()->sync($data["productos"]);
                }

                foreach ($data['productos'] as $id => $datos ) {
                    $producto = Producto::find($id);
                    $producto->disponible -= $datos['unidades'];
                    $producto->save();
                }

                return response()->json([
                    'ok'=>true,
                    'mensaje' => 'La venta se realizó correctamente',
                    'comentarios' => $data['comentarios'],
                    'comentarios1' => $venta->comentarios,
                ]);
            }else{
                $erroresSession = session('erroresCaja');

                $nuevoError = [
                    'venta' => [
                        'idTienda' => session('idTienda'),
                        'idUsuario' => Auth::user()->id,
                        'importe' => $data['total'],
                        'fecha' => new DateTime('NOW'),
                        'comentarios' => $data['comentarios'],
                        'productosSinStock' => $this->verificarStock($data['productos']),
                        'productos' => $data['productos'],
                    ]
                ];

                array_push($erroresSession, $nuevoError);

                session(['erroresCaja' => $erroresSession]);

                return response()->json([
                    'ok'=>false,
                    'mensaje' => 'La venta no se realizó correctamente',
                    'productosSinStock' => $this->verificarStock($data['productos']),
                ]);
            }
        }
    }

    private function verificarStock($productos)
    {
        $sinStock = [];
        foreach ($productos as $id => $datos ) {
            $producto = Producto::find($id);
            if ($producto->disponible < $datos['unidades']) {
                array_push($sinStock,$id);
            }
        }
        if (count($sinStock) > 0) {
            return $sinStock;
        }else{
            return null;
        }
    }

    public function cierreCajaUsuario(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $cierre = Cierre::find(session('idCierre'));
            $cierre->fill([
                'billetes' => $data['billetes'],
                'monedas' => $data['monedas'],
                'total' => $data['billetes'] + $data['monedas'],
                'comentarios' => $data['comentarios']
            ]);
            if ($cierre->save()) {
                session()->forget('fechaCajaAbierta');
                session()->forget('idCierre');
                return response()->json([
                    'ok' => true,
                    'redirectTo' => route('tienda'),
                ]);
            }
        }
    }

    public function showVentas()
    {
        $tienda = Tienda::find(session('idTienda'));
        $ventas = Venta::where('idTienda',session('idTienda'));

        if(session()->has("fechaCajaAbierta")){
            $ventas = $ventas->where('created_at','>=', session('fechaCajaAbierta'));
        }

        $ventas = $ventas->paginate(10);
        //dd($ventas);
        return view('tienda.caja.ventas.inicio')
            ->with('tiendaLog',$tienda)
            ->with('ventas',$ventas);
    }

    public function showVenta($id, Request $request)
    {
        $tienda = Tienda::find(session('idTienda'));
        $venta = Venta::find($id);

        return view('tienda.caja.ventas.venta')
            ->with('tiendaLog',$tienda)
            ->with('venta',$venta);
    }

}
