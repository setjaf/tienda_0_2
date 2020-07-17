<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (session()->has('idTienda') && (Auth::user()->trabajaEn->contains(session('idTienda')) ||  Auth::user()->administra->id == session('idTienda'))) {
                return redirect()->route('tienda');
            }elseif (Auth::user()->rol->id == 2) {
                return redirect()->route('tiendas');
            }
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
