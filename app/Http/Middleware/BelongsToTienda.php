<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class BelongsToTienda
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if( $user->administra->contains('id',session('idTienda')) || $user->trabajaEn->contains('id',session('idTienda')) ){
            return $next($request);
        }
        return redirect()->route('tienda.showLogin');
    }
}
