<?php

namespace App\Functions;

use Illuminate\Support\Facades\Auth;
use App\UserCompanion;
use App\Underage;
use App\RelationType;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class HotelTool extends Model
{
    public static function processJson($json, $properties){

        $decoded_json = json_decode($json);

        foreach($properties as $property){
            if(!isset($decoded_json->$property)){
                return false;
            }
        }

        return $decoded_json;
    }

    public static function verifyReservationPerson($people, $modelName){
        
        if(count($people)>0){

            foreach($people as $person){
                $existingPerson = UserCompanion::where('id_number', $person->id)->get();

                if(count($existingPerson)<1){
                    return ['message'=>'La persona con el número de identifación ('.$person->id.'), '
                    .'no esta en nuestros registros, verifique nuevamente.'];
                }

                $verifiedPerson = $modelName::where('id', $existingPerson[0]->id)
                ->where('user_id', Auth::id())->get();

                if(count($verifiedPerson)<1){
                    return ['message'=>'La persona con el número de identificación ('.$person->id.'), '
                    .'no esta asociada a su perfil, para asociar una persona a su perfil, dirijase a las '. 
                    'opciones de su perfil, haga click en personas, y agregue una nueva persona haciendo click en el '. 
                    'boton "agregar nueva persona".'];
                }

            }

        }
        return ['message'=>1];
    }

    public static function attachReservationPeople($params){
        $related_people_ids=[];
        $reservation=$params['reservation_request'];
        $property=$params['request_property'];
        foreach($reservation->$property as $person){

            // $found_person_id = UserCompanion::where('id_number', )
            // ->select('id')->first()->id;

            $related_person_id = $params['model_name']::where('id_number', $person->id)
            ->where('user_id', Auth::id())->first()->id;
            
            array_push($related_people_ids, $related_person_id);

        }//foreach people

        $reservation=$params['reservation_insert'];
        $property=$params['model_property'];

        try{ $reservation->$property()->attach($related_people_ids);  }
        catch(\Exception $e){
            return false;
        }
        $related_people_ids=$reservation=$property=null;
        return true;
    }

    public static function ommitQueryFields($fields, $entity){
       
        foreach($fields as $field){  unset( $entity->$field);  }
    }

    public static function formatDates($dates, $entity){
        foreach($dates as $date){
            if($entity[$date]!=null){
            $entity[$date] = new Carbon($entity[$date]); 
            $entity[$date] = $entity[$date]->format('d-m-Y H:i:s');
            }
        }
    }

    //Companions and underages

public static function getRelatedUserPeople($entity){

    $entity='App\\'.$entity;
    $related_people = $entity::where('user_id', Auth::id())
    ->orderBy('created_at', 'desc')->paginate(5);

        foreach($related_people as $related_person){ 

            // $related_person->is_token_expired= 0;

            // if(Carbon::now() >= new Carbon($related_person->token_verification)){
            //     $related_person->is_token_expired= 1;
            // }
            
            $dataToFilter = [
               
                ['fields'=>['is_underage_adult_relation', 'id']
                ,'entity'=>$related_person->relation_type ],
                ['fields'=>['user_id', 'relation_type_id' ,'id_card_number_type_id',
                'updated_at', 'deleted_at', 'phone_number', 'email', 'address'],
                'entity'=>$related_person],
                ['fields'=>['id_card_number_type', 'id'],
                'entity'=>$related_person->id_number_type ], 
            ];
            
  
            foreach($dataToFilter as $data){
                static::ommitQueryFields($data['fields'], $data['entity']);
            }
            // $related_person->id_number_type;
           
            static::formatDates(['created_at', 'birth_date'], $related_person);           
        }   

        // $rejected_count = $entity::where('user_id', Auth::id())
        // ->where('is_rejected', 1)->count();

        $route_entity='companions';
        // if($entity=='App\Underage'){
        //     $route_entity='underages';
        //     $relationship_types = RelationType::whereNull('is_underage_adult_relation')
        //     ->orWhere('is_underage_adult_relation', );
        // }
        $relationship_types = RelationType::all('type');
        return compact('related_people', 'relationship_types', 'route_entity' );
    }

public static function updateRelatedUserPerson($entity, $request, $id)
{
    $entity='App\\'.$entity;
    $rows = $entity::where('id',$id)->get();
    if(count($rows)<1){
        return response()->json(['message'=>'No se pudo encontrar la relación con esta persona.',
        'success'=>false]);
    }
   $rows[0]->relation_type_id=RelationType::where('type', $request->relationship)->select('id')->first()->id;
   if(!$rows[0]->save()){
    return response()->json(['message'=>'No se pudo actualizar la relación con esta persona.',
    'success'=>false]);
    }
    $route_entity='adults';
    if($entity=='App\Underage'){$route_entity='underages';}

    return response()->json(['message'=>'El tipo de relación fue actualizado a '.$request->relationship.'.',
    'success'=>true, 'route_entity'=>$route_entity]);
}

public static function formatDate($date, $format){
    $date= new Carbon($date);  $date=$date->format($format); return $date;
}

public static function storeReservationRoom($reservation_rooms, $id){
    
    DB::begintransaction();
    
    foreach($reservation_rooms as $room){

        $reserved_room_ids=[]; $available_rooms=[];
        $payment_total+=$room->amount*
        RoomType::where('id', $room->id)->first()->price_per_day*$diff;           

        $reservations = Reservation::
        join('reservation_rooms', 'reservations.id', '=', 'reservation_rooms.reservation_id')
        ->join('rooms', 'rooms.id', '=','reservation_rooms.room_id')
        ->join('room_types', 'room_types.id', '=','rooms.room_type_id')
        ->where('room_types.id', $room->id)
        ->where(function($query) use ($check_in, $check_out){
            $query->where([['check_in', '>=' ,$check_in],['check_in', '<=' ,$check_out]])
                    ->orwhere([['check_out', '>=' ,$check_in],['check_out', '<=' ,$check_out]])
                    ->orwhere([['check_in', '<=' ,$check_in],['check_out', '>=' ,$check_out]]);
        })->select('reservations.*')->get(); 

        if(count($reservations)>0){       
        
            $matched_reservations = [$reservations[0]];
            $pass=true;
            foreach($reservations as $reservation){
                foreach($matched_reservations as $matched_reservation){
                    if($matched_reservation->id == $reservation->id){
                        $pass = false;  break;
                    }else {$pass=true;}
                }
                if($pass){array_push($matched_reservations, $reservation);}
            }
            $reservations=$matched_reservations; $matched_reservations=null;

            foreach($reservations as $reservation){
                foreach($reservation->rooms as $reservation_room){
                    if($reservation_room->type->id==$room->id){
                        array_push($reserved_room_ids, $reservation_room->id ); 
                    }
                }
            }
        
            //select all rooms of current type
            $payment_total=0;
            $rooms = Room::where('room_type_id', $room->id)->select('id')->get();
            //compare to reserved_room_ids array
            for($i=0; $i < count($rooms); $i++){
                $pass=true;
                for($j=0; $j < count($reserved_room_ids); $j++){
                    //if matched, splice arrays
                    if($rooms[$i]->id == $reserved_room_ids[$j]){
                        $pass=false;
                        break;
                    }
                }
                if($pass){
                    array_push($available_rooms, $rooms[$i]->id); }

            }
        } else {
            foreach(Room::where('room_type_id', $room->id)->get()
            as $available_room) { array_push($available_rooms, $available_room->id); }
        }
        
        
        //attaching rooms to reservation
        for($i=0; $i < $room->amount; $i++){

            $random=rand(0, (count($available_rooms)-1));

            try{
                $reservation_insert->rooms()
                ->attach($available_rooms[$random]);
                array_splice($available_rooms, $random, 1);
            }catch(\Exception $e){
                DB::rollback();

                return response()->json(['message'=>'Hubo un error con el registro de
                sus habitaciones, intente nuevamente.']);
            }
           
        }
    }//foreach room
    DB::commit();
    return 1;
}


}//class





