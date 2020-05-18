<?php

namespace App\Http\Controllers\Tienda;

use App\Http\Controllers\Controller;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TiendasController extends Controller
{

    public function __construct()
    {
        // Revisa si hay un usuario loggeado
        $this->middleware('auth',['except'=>['login','showLogin']]);
        // Comprueba si el correo del usuario actual está verificado
        $this->middleware('verified',['except'=>['login','showLogin']]);
        // Verifica que el usuario loggeado sea un administrador
        $this->middleware('isAdmin',['except'=>['login','showLogin']]);
    }

    public function showTiendas(){
        if(Auth::user()->tiendas->count() == 0)
            return  redirect()->route('tiendas.nueva');
        if(session()->has('idTienda'))
            return redirect()->route('tienda');
        //dd(session()->get('idTienda'));
        return view('tienda.tiendas')->with('tiendas',Auth::user()->tiendas);
    }

    public function showNueva(){
        return view('tienda.nueva');
    }

    public function nueva(Request $request){

        $user = Auth::user();

        $data = $request->all();

        $this->nuevaValidator($data)->validate();

        $data = array_merge($data,['idUsuario'=>$user->id]);

        $tienda = Tienda::create($data);

        if (isset(request()->imagen)) {
            $filename = $tienda->id.'.'.request()->imagen->getClientOriginalExtension();
            request()->imagen->move(public_path('img/tiendas'), $filename);

            $tienda->imagen=$filename;

            $tienda->save();
        }

        if($tienda!=null){
            return redirect('tiendas')->with('messageError',"La tienda {$tienda->nombre} se ha creado correctamente.");
        }

        return back()->withInput($data)->with('messageError',true);

    }

    public function nuevaValidator($data){
        return Validator::make($data,
            [
                'nombre'=>'string|required|max:255',
                'calle'=>'string|required|max:255',
                'numero'=>'string|required|max:255',
                'cp'=>'string|required|max:5|min:5'
            ]
        );
    }
}
