<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\IdCardNumberType;
use App\People;
use App\Country;
use App\Locality;
use App\TableName;
use App\PolymorphicLog;
use Illuminate\Database\Eloquent\Model;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
      // protected $redirectTo = RouteServiceProvider::HOME;
      protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {   
        $limitDate = date("d-m-Y", strtotime(date("d-m-Y") . " - 18 year"));
        $validator = Validator::make($data, [
            'id_number_type' => ['bail','required', 'string', 'max:3','exists:App\IdCardNumberType,abbreviation'],
            'id_number' => ['bail','required', 'string','unique:people', 'max:20','regex:/^[0-9]{8,20}$/'],
            'name' => ['bail','required', 'string', 'max:40'],
            'lastname' => ['bail','required', 'string', 'max:40'],
            'locality' => ['bail','required', 'string', 'max:100', 'exists:App\Locality,name'],
            // 'address' => ['bail','string', 'max:150', 'regex:/^[أ-يa-zA-Z0-9а-яА-Я.,\-\(\) ]{2,150}$/'],
            'address' => ['nullable','max:150', 'regex:/^[^<>?\/\\|\|{}\[\]\+\=&\^%\$@!`~]{2,150}$/'],
            'phone_number' => ['nullable','max:30','unique:people','regex:/^[0-9\+\(\)\- ]{8,30}$/'],
            'birth_date' => ['bail','required','date', 'before_or_equal:'.$limitDate],
            'email' => ['bail','required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['bail','required', 'string', 'min:8', 'confirmed'],
        ]);
        $validator->setAttributeNames([
            'id_number_type' => 'tipo de identificación',
            'id_number' => 'número de identificación',
            'name' => 'nombre',
            'lastname' => 'apellido',
            'locality' => 'ciudad',
            'address' => 'dirección',
            'phone_number' => 'número de teléfono',
            'birth_date' => 'fecha de nacimiento',
            'email' => 'correo',
            'password' => 'contraseña'

        ]);
        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $id_type = IdCardNumberType::where('abbreviation', $data['id_number_type'])->first();
        $locality = Locality::where('name', $data['locality'])->first();
        
        $person = People::create([
            'locality_id'=>$locality->id,
            'id_card_number_type_id'=>$id_type->id,
            'id_number'=>$data['id_number'],
            'name'=> ucfirst($data['name']) ,
            'lastname' => ucfirst($data['lastname']),
            'address' => $data['address'],
            'phone_number' => $data['phone_number'],
            'birth_date' => $data['birth_date'],
        ]);


        $user = User::create([
            'person_id' => $person->id,
            'user_role_id' => 1,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $logKeys=[  ['table_name'=>'people', 'record_id'=>$person->id, 'data'=>$person],
                    ['table_name'=>'users', 'record_id'=>$user->id, 'data'=>$user]];
        foreach($logKeys as $logKey){
            PolymorphicLog::create(
                ['transaction_id'=>1,
                'table_name_id'=>TableName::where('table_name', $logKey['table_name'])->first()->id,
                'user_id'=> $user->id,
                'record_id'=>$logKey['record_id'],
                'data'=>json_encode($logKey['data'])]
            );
        }

        return $user;

    }

    // Overriding showRegistrationForm to populate select fields for id_number type
    // countries, states, and cities

    public function showRegistrationForm()
    {   
        $id_number_types = IdCardNumberType::all();
        for ($i=0; $i < count($id_number_types); $i++) { 
            $id_number_types[$i]=$id_number_types[$i]->abbreviation;
        }

        $countries = $this->getSystemData(new Country(), 'name');

        $data['id_number_types']= $id_number_types;
        $data['countries']= $countries;
        return view('auth.register', compact('data'));
    }

    private function getSystemData(Model $systemData, $property){
        $data = $systemData::all();
        for ($i=0; $i < count($data); $i++) { 
            $data[$i]=$data[$i]->$property;
        }
        return $data;
    }
}
