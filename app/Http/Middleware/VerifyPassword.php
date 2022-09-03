<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Auth;

class VerifyPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Requests\ProfileUpdateRequest  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        if(Hash::check($request->user_password, User::findOrFail(Auth::id())->password)) {
            return $next($request);
        } 

        return response()->json(['title' =>"Contraseña invalida...",
        'text' => "La contraseña ingresada es invalida, la actualización de su perfil no se pudo llevar a cabo.",
        'icon' => 'warning',
        'button' => 'Volver a intentar',
        'className' => 'alert'
        ]);
    }
}
