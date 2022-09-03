<?php

namespace App\Http\Middleware;

use Closure;
use App\Country;
use App\Region;
use App\Http\Requests\CountryRegionRequest;

class VerifyCountryDataExistence
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
        
        $parentData=null;
        $message=[
            'title' =>"País no encontrado...",
            'text' => "El país seleccionado no pudo ser encontrado en nuestros registros.",
            'icon' => 'warning',
            'button' => 'Volver a intentar',
            'className' => 'alert'
        ];
        $property= 'regions';

        if($request->country){
            $request->validate([
                'country' => ['required', 'max:80'],
            ]);
            $parentData = Country::where('name', $request->country)->first();
        }

        if($request->region){
            $message['title'] = "Estado no encontrado...";
            $message['text'] = "El estado seleccionado no pudo ser encontrado en nuestros registros."; 
            $parentData = Region::where('name', $request->region)->first();
            $property= 'localities';
        }
        if(!$parentData){
            return response()->json($message);
        }

        $childrenData = $parentData->$property;

        if(!$childrenData || count($childrenData) < 1){
            if($property == 'regions'){
                $message['title'] = 'No se econtraron estados...';
                $message['text'] = 'Los estados del país seleccionado no pudieron ser encontrados.';

            }else if($property == 'localities'){
                $message['title'] = 'No se econtraron ciudades...';
                $message['text'] = 'las ciudades del estado seleccionado no pudieron ser encontradas.';
            }
            return response()->json($message);
        }
        return $next($request);
         
    }
}
