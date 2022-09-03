<?php

namespace App\Rules\UserRelatedPeople;

use Illuminate\Contracts\Validation\Rule;
use App\People;
use App\User;
use App\UserCompanion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VerifiedUser implements Rule
{
    public $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $person = People::where('id_number', $value)->first();
        //check birth_date
        if(new Carbon($person->birth_date) > Carbon::now()->subYears(18)){
            $this->message='La persona a agregar es menor de edad, debe seleccionar la opción de menored de edad en el campo que se encuentra al lado izquierdo del boton agregar persona para poder asociar un menor de edad a su perfil.'; 
            return false; 
        }
        //check user existance
        $user = User::where('person_id', $person->id)->get();
        if(count($user)>0){ 
                // $this->message='El usuario de esta persona no pudo ser encontrado. es probable que la persona no se haya registrado, o si esta tratando de agregar un menor por favor cambie la opción de personas de adultos a menores de edad. '; 
                // return false; 
            // }else { $user=$user[0]; }
            //Check verified user
            if($user->email_verified_at == null){
                $this->message='La persona que desea agregar no esta verificada. Esta debe verificar su correo para poder disfrutar de nuestros servicios.'; 
                return false; 
            } 
            if($user->id == Auth::id()){
                $this->message='No puede agregarse a usted mismo a sus personas asociadas, este modulo esta hecho para que usted como cliente pueda llevar un mejor control de las personas que se hospedarán con usted maximizando así la seguridad de los mismos.'; 
                return false; 
            }

        }

        if(count(UserCompanion::where('person_id', $person->id)
        ->where('user_id', Auth::id())->where('is_rejected', 1)->get()) > 0){
            
            $this->message='La persona que trata de agregar, ya rechazó su solicitud pasada. Cuando esta persona levante el bloqueo, usted podrá agregarla nuevamente.'; 
            return false; 
        }
        
        if(
            count(UserCompanion::where('person_id', $person->id)
            ->where('user_id',Auth::id())->get()) > 0
        ){
            $this->message='La persona que desea agregar ya esta asociada a su perfil.'; 
            return false; 
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
