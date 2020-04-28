<?php

namespace App\Http\Controllers\Tienda;


use App\Http\Controllers\Controller;
use App\Models\Tienda;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TiendaController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/tienda';

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
        $this->middleware('tiendaOpen',['except'=>['cerrar']]);
    }



    public function entrar(Request $request){
        session()->forget('idTienda');
        session(['idTienda'=>$request->all()['idTienda']]);
        Auth::logout();
        return redirect()->route('tienda.showLogin');
    }

    public function cerrar(Request $request){
        dd(session()->has('idTienda'));
        session()->forget('idTienda');
        dd(session()->has('idTienda'));
        return redirect()->route('tiendas');
    }

    public function showLogin()
    {
        $tienda = Tienda::find(session('idTienda'));
        return view('auth.login')->with('tienda',$tienda);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $tienda = Tienda::find(session('idTienda'));

        $email = $request->only('email')['email'];

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        dd($tienda->empleados->where('email',$email)->first());

        if($tienda->empleados->where('email',$email)->first()!=null || $tienda->administrador->email == $email){

            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
            $this->incrementLoginAttempts($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.


        return $this->sendFailedLoginResponse($request);
    }

    public function showTienda()
    {
        dd(Auth::user());
        return ;
    }

}
