<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileUpdateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

//models
use App\User;
use App\People;
use App\IdCardNumberType;
use App\Country;
use App\Region;
use App\Locality;
use App\PolymorphicLog;
use App\TableName;
use App\UserCompanion;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(){
        $user = User::findOrFail(Auth::id());
        $user->person;
        $user->person->id_number_type;
        $user->person->locality;
        $user->person->locality->region;
        $user->person->locality->region->country;

        $idNumberTypes=IdCardNumberType::all(['abbreviation']);

        $countries = Country::all();

        return view('profile',compact(['user', 'idNumberTypes', 'countries']));
        //  return compact(['user', 'idNumberTypes']);
    }
    
    public function update(ProfileUpdateRequest $request){

        $result=0;$updatedEmail=false;

        $user = User::findOrFail(Auth::id());
        $user->person;
        if($user['person'][$request->fieldName]){

            $person = People::findOrFail($user['person_id']);
            
            if($request->fieldName == 'locality_id'){
                $person['locality_id']=
                Locality::where('name', $request->fieldValue)->first()->id;
            }
            else {
                $person[$request->fieldName] = $request->fieldValue;
                
            }
            if($request->id_number_type){
                $person['id_card_number_type_id']=
                IdCardNumberType::where('abbreviation', $request->id_number_type)->first()->id;
            }

            $result = $person->save();
            $table_name_id=TableName::where('table_name','people')->first()->id;
            PolymorphicLog::create(
                ['transaction_id'=>2,
                'table_name_id'=>TableName::where('table_name','people')->first()->id,
                'user_id'=> Auth::id(),
                'record_id'=>$person->id,
                'data'=>'{"'.$request->fieldName.'":"'.$request->fieldValue.'"}']
            );
        }
        else{

            if($request->fieldName == 'password') {
                $user['password']=Hash::make($request->fieldValue);
            }else {
                $user[$request->fieldName] = $request->fieldValue;

                if($request->fieldName == 'email'){
                    $user['email_verified_at']=NULL;
                    $updatedEmail=true;
                    
                }
            }
            $result = $user->save();

            $valueToStore=$request->fieldValue; 
            if($request->fieldName=='password'){ //this avoids storing the plain password in the logs
                $valueToStore=$user->password;
            }
            PolymorphicLog::create(
                ['transaction_id'=>2,
                'table_name_id'=>TableName::where('table_name','users')->first()->id,
                'user_id'=> Auth::id(),
                'record_id'=>$user->id,
                'data'=>'{"'.$request->fieldName.'":"'.$valueToStore.'"}']
            );

            if($updatedEmail){$user->sendEmailVerificationNotification();}
        }

        if($result!=1){
            return response()->json(['title' =>"Error...",
            'text' => "La actualización 
                de su perfil no se pudo llevar a cabo, intente más tarde.",
            'icon' => 'warning',
            'button' => 'Volver a intentar',
            'className' => 'alert'
            ]);
        }
        return response()->json([
            'title' =>"Perfil Actualizado.",
            'text' => "La actualización de su perfil fue llevada a cabo exitosamente.",
            'icon' => 'success',
            'button' => 'Aceptar',
            'className' => 'alert'
            
        ]);
    }

    /*RELATED PEOPLE: COMPANIONS, UNDERAGES*/

    public function getRelatedPeople(Request $request){

        $companions = UserCompanion::where('user_id', Auth::id())->get();
        foreach ($companions as $companion) {
            $companion->relation_type;
            $companion->id_number_type;
        }

        return compact('companions');

    }//related People
}
