<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Auth;

class CheckAdminRole
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
        if(Auth::user()->user_role_id != 3){
            Session::flash('error_message', 'No tienes permisos para acceder ese módulo.'); 
            return redirect()->route('home');
        } 

        return $next($request);
    }
}
