<?php

namespace App\Http\Middleware\People;

use Closure;
use Illuminate\Support\Facades\Hash;
use App\UserCompanion;
use Carbon\Carbon;
use Session;

class UserRelatedPersonValidation
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
        //Existance validation
        $message='No se pudo procesar la solicitud para asociar con el perfil porque ';
        
        if(!isset($request->t) || !isset($request->c) || !isset($request->a) ){
            Session::flash('error_message', $message.'faltan parametros en su solicitud.'); 
            return redirect()->route('home');
        }

        if(!is_numeric($request->c) || !is_numeric($request->a)){
            Session::flash('error_message', $message.'hay parametros que solo pueden ser númericos.'); 
            return redirect()->route('home');
        }

        if($request->c < 1 || $request->a < 0){
            Session::flash('error_message', $message.'no se permiten valores negativos.'); 
            return redirect()->route('home');
        }

        $companion = UserCompanion::where('id', $request->c )->get();

         if( count($companion) < 1){
            Session::flash('error_message', $message.'no existe relación.'); 
            return redirect()->route('home');
        }

        $companion = $companion[0];

        if($request->a > 1 || $request->a < 0){
            Session::flash('error_message', $message.'solo se permite 0 y 1 para el estado de solicitud.'); 
            return redirect()->route('home');
        }

        if(strlen($request->t) != 40){

            Session::flash('error_message', $message.'la cantidad de characteres es inválida.'); 
            return redirect()->route('home');
        }

        if ($companion->token==null) {
            Session::flash('error_message', $message.'el link ya fue utilizado. Dirijase a la opción de Personas > Relacionado/a a para ver quien lo agregó.'); 
            return redirect()->route('home');  
        }

        if(Carbon::now() >= new Carbon($companion->token_verification)){
            Session::flash('error_message', $message.'el token expiró, la persona que desea asociarte a su perfil debe re-enviar la solicitud desde el módulo de personas.'); 
            return redirect()->route('home');           
        }

        if (!Hash::check($request->t, $companion->token )) {
            Session::flash('error_message', $message.'el token es inválido. la persona que desea asociarte a su perfil puede re-enviar la solicitud desde el módulo de personas'); 
            return redirect()->route('home');  
        }

        return $next($request);
    }
}
