<?php

use Illuminate\Support\Facades\Route;
//testing
use App\IdCardNumberType;
use App\Locality;
use App\People;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Mail;
use App\Mail\PlainTextMail;
use App\Mail\TextMail;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index');

/** Countries  */

    /*regions*/
Route::post('country/regions', 
'World\CountryController@getCountryRegions')
->name('regions');
    /**Localities */
Route::post('region/localities', 
'World\RegionController@getRegionLocalities')
->name('localities');
/**Countries */

/** USER PROFILE */
Route::get('/profile', 'UserController@show')
->name('profile');

Route::post('/profile', 'UserController@update')
->name('updateProfile')->middleware('VerifyPassword');

/**RESERVATIONS */

Route::get('/related_people', 'UserController@getRelatedPeople')
->middleware('verified')->name('related_people');

Route::get('/room_types/by_type', 'Rooms\RoomTypeController@showByType')
->middleware('verified')->name('room_by_type');

Route::resource('reservations', 'Reservations\ReservationController');

/* Hotel companions */
Route::resource('user_companions', 'People\UserCompanionController');

Route::resource('adults', 'People\AdultController');
Route::resource('underages', 'People\UnderageController');

Route::get('/resend_approval_request',
 'People\AdultController@resendAssociationApprovalRequest')
->name('resendAssociationApprovalRequest');

Route::get('/show_user_people', function(){ 

    $relation_types=App\RelationType::select('type')->get();
    if(count($relation_types)<1){   
        Session::flash('error_message', 'Hubo un error al consultar ciertos datos, intente nuevamente.');
        return redirect()->route('home'); 
    }
    $id_number_types=App\IdCardNumberType::select('abbreviation')->get();
    if(count($id_number_types)<1){   
        Session::flash('error_message', 'Hubo un error al consultar ciertos datos, intente nuevamente.');
        return redirect()->route('home'); 
    }
    return view('people.user_people', compact('relation_types', 'id_number_types'));

})->middleware(['auth', 'verified'])->name('user_people');

Route::get('/user_profile_association',
 'People\AdultController@handlePersonAssociationApprovalRequest')
->name('user_profile_association');

Route::get('/show_user_reservations', function(){ 
    return view('reservations.user_reservations');
})->name('user_reservations');

Route::resource('/payments/movements', 'Payments\BankMovements\BankMovementController');

 //PRODUCTS VIEW
Route::get('/shopping', 'Client\ClientPanelController@get_products')->name('client_products');   
 //SUPPLY RESTful routes
Route::resource('/products', 'Product\ProductController'); 

//ADMIN PANEL

Route::get('/admin', 'Admin\AdminPanelController@get_admin_panel')->name('admin_panel');

    //CURRENCIES

    //CURRENCY VIEW
Route::get('/admin/currencies', 'Admin\AdminPanelController@get_admin_currencies')->name('admin_currencies');   
    //CURRENCIES RESTful routes
Route::resource('/currencies', 'Finances\CurrencyController');   

    //BANKS VIEW
Route::get('/admin/banks', 'Admin\AdminPanelController@get_admin_banks')->name('admin_banks');   
    //BANKS RESTful routes
Route::resource('/banks', 'Finances\BankController');   

    //BANK_ACCOUNTs VIEW
Route::get('/admin/bank_accounts', 'Admin\AdminPanelController@get_admin_bank_accounts')->name('admin_bank_accounts');   
    //BANK_ACCOUNTs RESTful routes
Route::resource('/bank_accounts', 'Finances\BankAccountController');   

    //SUPPLY VIEW
Route::get('/admin/supplies', 'Admin\AdminPanelController@get_hotel_supplies')->name('admin_supplies');   
    //SUPPLY RESTful routes
Route::resource('/supplies', 'Supply\SupplyController'); 

    //PROVIDERS VIEW
Route::get('/admin/providers', 'Admin\AdminPanelController@get_providers')->name('admin_providers');   
    //PROVIDERs RESTful routes
Route::resource('/providers', 'Provider\SupplyController'); 

   
//TEST ///////////////////////////////////////////////////////////////////////////////

Route::get('/test', function(){
    $person = App\People::where('id',1)->first();
    // $user = App\User::where('email','molero3111@gmail.com')->first();
    $person->user;

    $person->user->companions;
      foreach($person->user->companions as $companion){
        $companion->pivot->relation_type;
    }

    $person->user->underages;
      foreach($person->user->underages as $underage){
        $underage->pivot->relation_type;
    }

    for($i = 0; $i < count($person->user->reservations); $i++){
        $person->user->reservations[$i]->companions;
       
        foreach( $person->user->reservations[$i]->companions as $companion){
          $companion->relation_type;
          $companion->person;

        }

        $person->user->reservations[$i]->underages;
       
        foreach( $person->user->reservations[$i]->underages as $underage){
          $underage->relation_type;
          $underage->person;

        }
        $person->user->reservations[$i]->rooms;
        $person->user->reservations[$i]->visits;

        for( $j = 0; $j < count($person->user->reservations[$i]->rooms); $j++){

            $person->user->reservations[$i]->rooms[$j]->type;
            $person->user->reservations[$i]->rooms[$j]->status;
        
            for( $k = 0; $k < count($person->user->reservations[$i]->rooms[$j]->visits); $k++){

                $person->user->reservations[$i]->rooms[$j]->visits[$k]->visitors;
            }
        }

        
    }

    // foreach($person->user->reservations as $reservation){
    //     $reservation->companions;
    // }

    // $reservation = App\Reservation::where('id',1)->first();

    // $reservation->companions;
    // return App\UserCompanion::all()->get();
    return $person;
});

Route::get('/reservations/{check_in}/{check_out}', function($check_in, $check_out){


    // $reservations = DB::select("select * from reservations where (check_in >='2020-07-01' and 
    // check_in <='2020-07-15') or (check_out >='2020-07-01' and check_out <='2020-07-15')");
    
    $room_types = DB::select("SELECT count(*) from rooms where room_type_id=1 ");
//     $reservations = DB::select("SELECT reservations.*
// FROM
//     reservations inner join reservation_rooms on reservation_rooms.reservation_id=reservations.id
//     inner join rooms on rooms.id=reservation_rooms.room_id
// WHERE
//     ((check_in >= '$check_in' AND check_in <='$check_out')
// OR
//     (check_out >= '$check_in' AND check_out <= '$check_out')
// OR
// (check_in <= '$check_in' AND check_out >='$check_out'))
// AND (room_type_id=1);
// ");
$reservations = App\Reservation::
join('reservation_rooms', 'reservations.id', '=', 'reservation_rooms.reservation_id')
->join('rooms', 'rooms.id', '=','reservation_rooms.room_id')
->join('room_types', 'room_types.id', '=','rooms.room_type_id')
->where('room_types.id', '<=', 1)
->where(function($query) use ($check_in, $check_out){
    $query->where([['check_in', '>=' ,$check_in],['check_in', '<=' ,$check_out]])
            ->orwhere([['check_out', '>=' ,$check_in],['check_out', '<=' ,$check_out]])
            ->orwhere([['check_in', '<=' ,$check_in],['check_out', '>=' ,$check_out]]);
})->select('reservations.*')->get();

foreach($reservations as $reservation){
    $reservation->rooms;

    foreach($reservation->rooms as $room){
        $room->type;
        
    }
    
}
    // return compact('result', 'reservations');
    return compact('room_types','reservations');
});

Route::get('/string', function(){
    return Str::random(40);
});

Route::get('/rooms_out/{check_in}/{check_out}', function($check_in, $check_out){

   $rooms= App\Room::join('reservation_rooms', 'room.id', '=', 'reservation_rooms.room_id')
    ->join('reservations', 'reservations.id', '=','reservation_rooms.reservation_id')
    ->join('room_types', 'room_types.id', '=','rooms.room_type_id')
    ->where('room_types.type', 'Habitación Simple')
    ->where(function($query) use ($check_in, $check_out){
        $query->where([['check_in', '<=' ,$check_in],['check_in', '>=' ,$check_out]])
                ->orwhere([['check_out', '<=' ,$check_in],['check_out', '>=' ,$check_out]])
                ->orwhere([['check_in', '>=' ,$check_in],['check_out', '<=' ,$check_out]]);
    });
    return compact('rooms');
});

Route::get('/rooms_in/{check_in}/{check_out}', function($check_in, $check_out){

    $rooms = App\Room::
    join('reservation_rooms', 'room.id', '=', 'reservation_rooms.room_id')
    ->join('reservations', 'reservations.id', '=','reservation_rooms.reservation_id')
    ->where('rooms.room_type_id', 1)
    ->where(function($query) use ($check_in, $check_out){
        $query->where([['reservations.check_in', '>=' ,$check_in],['reservations.check_in', '<=' ,$check_out]])
                ->orwhere([['reservations.check_out', '>=' ,$check_in],['reservations.check_out', '<=' ,$check_out]])
                ->orwhere([['reservations.check_in', '<=' ,$check_in],['reservations.check_out', '>=' ,$check_out]]);
    });

    return compact('rooms');

    $a= 'select rooms.* from rooms inner join room_types on room_types.id=rooms.room_type_id
    inner join reservation_rooms ';
});
Route::get('/testmail', function(){

    return Mail::to('molero3111@gmail.com')
    ->send(new TextMail('my param'));

   
});

Route::get('/testdate', 
function(){ 
   $now = Carbon\Carbon::now();
   $plus_hour= Carbon\Carbon::now()->addHours(1)->format('Y-m-d H:i:s');
   $token_verification = App\UserCompanion::where('id',86)->first()->token_verification;
   $token_verification = new Carbon\Carbon($token_verification);
//    $date->format('Y-m-d H:i:s');
   $result='no';
   if($now >  $token_verification){
       $result = 'yeah';
   }
   $token= Str::random(40);
   $hash = Hash::make($token);
   
   return compact('now', 'plus_hour', 'token', 'hash', 'result', 'token_verification');
});
