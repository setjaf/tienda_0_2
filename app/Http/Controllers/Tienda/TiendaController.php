<?php

namespace App\Http\Controllers\Tienda;


use App\Http\Controllers\Controller;
use App\Models\Asistencia;
use App\Models\Tienda;
use DateTime;
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
        $this->middleware('auth',['except'=>['cerrar','showLogin','login']]);
        // Comprueba si el correo del usuario actual está verificado
        $this->middleware('verified',['except'=>['cerrar','login','showLogin']]);
        // Verifica que una tienda esté iniciada, si no está iniciada te regresa a '/tiendas'
        $this->middleware('tiendaOpen',['except'=>['entrar']]);
        // Verifica que el usuario sea empleado o administrador de la tienda
        $this->middleware('belongsToTienda',['only'=>['showTienda']]);
    }

    public function entrar(Request $request){
        session()->forget('idTienda');
        session(['idTienda'=>$request->all()['idTienda']]);
        Auth::logout();
        return redirect()->route('tienda.showLogin');
    }

    public function cerrar(Request $request){
        session()->forget('idTienda');
        return redirect()->route('tiendas');
    }

    public function showLogin()
    {
        $tienda = Tienda::find(session('idTienda'));
        return view('auth.login')->with('tiendaLog',$tienda);
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

        if($tienda->empleados->where('email',$email)->first()!=null || $tienda->administrador->email == $email){

            if ($this->attemptLogin($request)) {
                //dd(Auth::user());
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
        //dd(Auth::user());
        $tienda = Tienda::find(session('idTienda'));
        return view('tienda.inicio')->with('tiendaLog',$tienda);
    }

    public function showEmpleadosAsistencia(Request $request)
    {
        if ($request->ajax()) {

            $tienda = Tienda::find(session('idTienda'));

            return view('tienda.empleados')
                ->with('empleadosSalida',$tienda->empleadosSalida())
                ->with('empleadosEntrada',$tienda->empleadosEntrada())
                ->render();
        }
    }

    public function empleadosAsistencia(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $hoy = (new DateTime('NOW'))->format('d-m-Y');
            $asistencia = null;
            if ($data['entrada']) {
                $asistencia = Asistencia::create([
                    'idEmpleado' => $data['idempleado'],
                    'idTienda' => session('idTienda'),
                    'entrada' => new DateTime('NOW')
                ]);
            }else{
                $asistencia = Asistencia::where(
                    [
                        ['idEmpleado',$data['idempleado']],
                        ['entrada','>=',new DateTime($hoy)],
                    ]
                )->first();
                $asistencia->salida = new DateTime('NOW');
                $asistencia->save();
            }

            $dataResponse = [];

            if ($asistencia != null) {
                $dataResponse = [
                    'ok' => true,
                    'entrada' => $data['entrada']?true:false,
                ];
            }else{
                $dataResponse = [
                    'ok' => false,
                ];
            }

            return response()->json($dataResponse);

        }
    }

}
