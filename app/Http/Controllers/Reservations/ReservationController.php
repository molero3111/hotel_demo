<?php

namespace App\Http\Controllers\Reservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Reservation;
use App\TableName;
use App\PolymorphicLog;
use App\Functions\HotelTool;
use App\Room;
use App\RoomType;
use App\Payment;
use Carbon\Carbon;


class ReservationController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('verified');

        $this->middleware('ReservationAvailability')->only('store');

        $this->middleware('VerifyRelatedPeople')->only('store');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**returns all reservations of the logged user */
        $reservations = Reservation::where('user_id', Auth::id())
        ->orderBy('created_at', 'desc')->paginate(5);

        foreach ($reservations as $reservation) {
            HotelTool::ommitQueryFields( [ 'user_id'], $reservation);
            HotelTool::formatDates(['created_at', 'check_in', 
            'check_out', 'verified_at'], $reservation); 
        }
        return compact('reservations');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
        $reservation_request = HotelTool::processJson($request->reservation_data,
        ['check_in', 'check_out', 'rooms', 'companions']);

        if($reservation_request == false){
            return response()->json([
                'message'=>'Hubo un problema con los datos de sus reserva, intente nuevamente',
                'companions'=>$request->reservation_data
            ]);
        }
        
        $data=$request->reservation_data;

        DB::begintransaction();

        $payment_total=0;
        $check_in = Carbon::parse($reservation_request->check_in.' 00:00:00');
        $diff = $check_in->diffInDays(Carbon::parse($reservation_request->check_out.' 00:00:00') );
        $check_in = $reservation_request->check_in;
        $check_out = $reservation_request->check_out;

        $reservation_insert= Reservation::create([
            'user_id'=>Auth::id(),
            'check_in'=>$check_in,
            'check_out'=>$check_out,
            'created_at'=>Carbon::now()
        ]);

        if(!$reservation_insert){
            DB::rollback();
            return response()->json(['message'=>'Hubo un error con el registro de
             su reserva, intente nuevamente.']);
        }

        // PolymorphicLog::create(
        //     ['transaction_id'=>1,
        //     'table_name_id'=>TableName::where('table_name','reservations')->first()->id,
        //     'user_id'=> Auth::id(),
        //     'record_id'=>$reservation_insert->id,
        //     'data'=>json_encode($reservation_insert)]
        // );

        $reserved_room_ids=[]; $available_rooms=[]; $rooms;

         //select all reservations matching the date range

        foreach($reservation_request->rooms as $room){

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

        //attaching people
        $people_params=[
            [
                'request_property'=> 'companions',
                'model_name'=> 'App\UserCompanion',
                'model_property'=>'companions',
                'message_entity'=>'adultos'
            ]
        ];
        foreach($people_params as $person_params){
            $attached = HotelTool::attachReservationPeople([
                'reservation_request'=> $reservation_request,
                'request_property'=> $person_params['request_property'],
                'model_name'=> $person_params['model_name'],
                'reservation_insert'=>$reservation_insert,
                'model_property'=>$person_params['model_property'],
                ]);
                
            if(!$attached){
                DB::rollback();
                return response()->json(['message'=>'Hubo un error al asociar los '.
                $perso_params['message_entity']. 
                ' de su perfil a su solicitud de reserva, intente nuevamente.']);
            }
        }

        $people_params=null;

        //attaching payment
        if(!Payment::create(['reservation_id'=>$reservation_insert->id, 'total'=>$payment_total,
        'payment_service_id'=>1])){
            DB::rollback();
            return response()->json(['message'=>'Hubo un error al asociar el pago a su solicitud de reserva, intente nuevamente.']);
        }
        DB::commit();

        return response()->json(['message'=>'Su solicitud de reserva fue procesada exitosamente. '. 
        'A partir de ahora, tiene 24 horas para notificar el pago de su reserva, en caso contrario, '. 
        'sera anulada, y debera solicitar otra. Si desea editar su reserva lo puede hacer antes de realizar el pago, '. 
        'una vez que este se haya realizado, debera hacer otro pago a parte si desea agregar mas habitaciones.',
        'success'=>true,]);

    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reservation = Reservation::where('id',$id)->where('user_id', Auth::id())->orderBy('created_at', 'desc')->first();
        $reservation->total_paid=0;
        $reservation->created_at=HotelTool::formatDate($reservation->created_at,'d-m-Y H:i:s');
        $dates=['check_in', 'check_out'];
        foreach($dates as $date){ 
        $reservation[$date]=HotelTool::formatDate($reservation[$date],'d-m-Y');}
        $check_in= new Carbon($reservation['check_in']);
        $check_out= new Carbon($reservation['check_out']);
        $reservation->days = $check_in->diffInDays($check_out);
        
        foreach ($reservation->companions as $companion) {
            
            $companion->id_number_type;
            $companion->relation_type;
        }
        foreach ($reservation->rooms as $room) {
            $room->type;
        }
        foreach ($reservation->payments as $payment) {
           $payment->payment_service;
            foreach ($payment->bank_movements as $movement) {
                $movement->created_at=HotelTool::formatDate($movement->created_at,'d-m-Y H:i:s');
                $movement->payment_type;
                $movement->bank_account->bank->currency;
                if($movement->verified_at==null){
                    $movement->verified_at='En proceso.';
                }else {
                    $movement->verified_at=HotelTool::formatDate($movement->verified_at,'d-m-Y H:i:s');
                    $reservation->total_paid=$movement->total/$movement->equivallent_in_dollars;
                }
            }//bank_movements
        }//payments
        $room_types=RoomType::all();
        return view('reservations.reservation_details', compact('reservation', 'room_types'));
        return compact('reservation');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
