<?php

namespace App\Http\Middleware\Reservations;

use Closure;
use App\Functions\HotelTool;
use App\Room;
use App\Reservation;
use App\RoomType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CheckReservationAvailability
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
        $reservation = HotelTool::processJson($request->reservation_data,
        ['check_in', 'check_out', 'rooms', 'companions']);

        if($reservation == false){
            return response()->json([
                'message'=>'Hubo un problema con los datos de sus reserva, intente nuevamente'
            ]);
        }

        if(count($reservation->rooms)<1){
            return response()->json([
                'message'=>'No seleccionó ninguna habitación, debe haber al menos una habitacion para poder solicitar una reserva.'
            ]);
        }

        
        try{
            $check_in = new Carbon($reservation->check_in);
            $check_out = new Carbon($reservation->check_out);
            $current_date = new Carbon();
            $current_date->hour = 0;
            $current_date->minute = 0;
            $current_date->second = 0;
        }catch(\Exception $e){ 

            return response()->json([
                'message'=>'Las fechas ingresadas no son validas, verifique nuevamente por favor.'
            ]);    
        }

        if($check_in < $current_date || $check_out < $current_date){
            return response()->json([
                'message'=>'La fechas ingresadas no pueden ser antes de la fecha de hoy ('. $current_date->isoFormat('D-MM-Y') . 
                '), intente nuevamente.'
            ]);
        }
        if($check_out <= $check_in){
            return response()->json([
                'message'=>'La fecha de salida debe ser despues de la fecha de entrada ('
                .$check_in->isoFormat('D-MM-Y').').'
            ]);
        }

        

        /* to ensure users are making a reservation that does not match another of their reservations
        the check in date is checked  */
        $existing_reservations = Reservation::
        join('users', 'reservations.user_id', '=', 'users.id')
        ->where('users.id', Auth::id())
        ->where(function($query) use ($check_in, $check_out){
            $query->where([['check_in', '>=' ,$check_in],['check_in', '<=' ,$check_out]])
                    ->orwhere([['check_out', '>=' ,$check_in],['check_out', '<=' ,$check_out]])
                    ->orwhere([['check_in', '<=' ,$check_in],['check_out', '>=' ,$check_out]]);
        })->count();

        if($existing_reservations>0){
            return response()->json([
                'message'=>'Tiene una reserva que coincide con las fechas ingresadas, '. 
                'puede ir a su perfil, en la opcion de reservas, podra modificar '. 
                'la reserva que desee, puede cambiar las fechas, agregar habitaciones, personas, entre otros. '. 
                'Tenga en cuenta que al agregar mas días o más habitaciones a su reserva, tendra que '. 
                'realizar otro pago correspondiente a los cambios realizados.'
            ]);
        }

        $capacity = 0;
        foreach($reservation->rooms as $room){
            $room_type = RoomType::where('id', $room->id)->first();

            if(!$room_type){
                return response()->json([
                    'message'=>'Hubo un problema con los datos de la habitación, intente nuevamente.'
                ]);
            }

            if(!is_numeric($room->amount) || $room->amount < 1 ){
                return response()->json([
                    'message'=>'Ingreso un valor erroneo para la cantidad de habitaciones de tipo '.$room_type->type.'. '. 
                    'Asegurese de que sea un valor númerico igual o mayor a 1.',
                    'room'=>$room
                ]);
            }

            $capacity +=$room_type->capacity*$room->amount;
        }

        $people_amount= count($reservation->companions)+1;

        if($people_amount > $capacity){
            return response()->json([
                'message'=>'Su solicitud de reserva tiene ('.$people_amount.') personas '
                .'agregadas, y la capacidad total de la habitaciones que agregó es de ('.$capacity.') personas.'.
                'Por favor, agregue mas habitaciones a su reserva si desea reservar con las personas agregadas.'
            ]);
        }

        foreach($reservation->rooms as $room){

        $room_type = RoomType::where('id', $room->id)->first();//verify existance
       
        $rooms = Room::where('room_type_id',$room->id)->count();
        
        $existing_reservations = Reservation::
        join('reservation_rooms', 'reservations.id', '=', 'reservation_rooms.reservation_id')
        ->join('rooms', 'rooms.id', '=','reservation_rooms.room_id')
        ->join('room_types', 'room_types.id', '=','rooms.room_type_id')
        ->where('room_types.id', $room_type->id)
        ->where(function($query) use ($check_in, $check_out){
            $query->where([['check_in', '>=' ,$check_in],['check_in', '<=' ,$check_out]])
                    ->orwhere([['check_out', '>=' ,$check_in],['check_out', '<=' ,$check_out]])
                    ->orwhere([['check_in', '<=' ,$check_in],['check_out', '>=' ,$check_out]]);
        })->count();
        
        $available_rooms= $rooms - $existing_reservations;
        if($available_rooms <= 0){
            return response()->json([
                'message'=>'No hay habitaciones de tipo "'. $room_type->type . 
                '" disponibles para la fecha de ingreso '. $check_in . ', y la fecha de salida '. 
                $check_out .'.'
            ]);
        } 

        $available_rooms_after_reservation = $available_rooms - $room->amount;
        if($available_rooms_after_reservation<0){

            return response()->json([
                'message'=>'No hay suficientes habitaciones de tipo "'. $room_type->type . 
                '" disponibles. Su solicitud de reserva contiene ('.$room->amount.') habitacion(es), y '. 
                'solo hay ('.$available_rooms.') habitacion(es) disponibles.'
            ]);

        }
        
        }

        return $next($request);
    }
}
