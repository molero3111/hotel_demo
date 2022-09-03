<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }else{
            return response()->json([
               'title'=>'Acceso denegado.',
               'content'=>[ 'element'=>'p',
                            'attributes'=>[
                                'innerHTML'=>'<p class="swal-color">Debe iniciar sesión primero.</p>']],
                'class'=>'alert' 
            ]);
        }
    }
}
