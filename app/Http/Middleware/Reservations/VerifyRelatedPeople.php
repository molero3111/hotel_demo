<?php

namespace App\Http\Middleware\Reservations;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Functions\HotelTool;
use App\People;
use App\UserCompanion;

class VerifyRelatedPeople
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function handle($request, Closure $next){

        /* processJson function ensures that the properties on the json built on the reservation view exist*/
        $reservation = HotelTool::processJson($request->reservation_data,
        ['companions']);

        /** the function above would return false in case a property isnt set, which is used to
         * send an error message to the user */
        if($reservation == false){
            return response()->json([
                'message'=>'Hubo un problema con los datos de sus reserva, intente nuevamente'
            ]);
        }
        $people_arrays=[];

        if(count($reservation->companions)>0){
            array_push($people_arrays, ['array'=>$reservation->companions,'model_name'=>'App\UserCompanion']);
        }

        if(count($people_arrays)>0){
            foreach($people_arrays as $people_array){
                $result = HotelTool::verifyReservationPerson($people_array['array'],
                $people_array['model_name']);
                if($result['message']!=1){
                    return response()->json($result);
                }
            }
        }
        
        return $next($request);
    }
}
