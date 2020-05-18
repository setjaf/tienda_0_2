<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tienda;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return array_merge($request->only($this->username(), 'password'),['activo'=>1]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Si ya existe una tienda abierta, se hace la redirección al inicio de esa tienda.
        if (session()->has('idTienda')) {
            return redirect('tienda');
        }
        switch ($user->idRol) {
            case '1':
                $this->redirectTo = '/super';
                break;
            case '2':
                $this->redirectTo = '/tiendas';
                break;
            default:
                $this->redirectTo = '/home';
                break;
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $idTienda = null;

        if (session()->has('idTienda')) {
            $idTienda = session('idTienda');
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($idTienda != null) {
            session(['idTienda'=>$idTienda]);
            return redirect()->route('tienda.login');
        }

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }
}
