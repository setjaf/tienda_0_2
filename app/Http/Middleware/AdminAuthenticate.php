<?php

namespace App\Http\Middleware;

use App\Models\Rol;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
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

        if($user->rol != Rol::find(2)){
            return redirect('/');
        }

        return $next($request);
    }
}
