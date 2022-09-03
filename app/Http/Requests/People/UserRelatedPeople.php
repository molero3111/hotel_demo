<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\VerifyMailExistence;
use App\Rules\UserRelatedPeople\VerifiedUser;

class UserRelatedPeople extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_number'=>['bail','required','integer',
            'exists:App\People,id_number', new VerifiedUser()],
            'relation_type'=>['bail','required','regex:/^[\/A-Za-záÁéÉíÍóÓúÚñÑ]{2,100}$/','exists:App\RelationType,type'],
            'is_adult'=>['bail','required', 'boolean']
        ];
    }
    public function attributes()
    {
        return [
            'id_number' => 'número de identificación',
        ];
    }
    public function messages()
    {
        return [
            'id_number.exists' => 'El número de identificación de la persona que desea agregar no se encuentra en nuestros registros. La persona debe estar registrada en nuestro sistema si es adulta, o asociada a un perfil de si es menor de edad.',
            'relation_type.regex'=>'Solo pueden haber letras y el character / en el tipo de parentesco.',
            'is_adult.boolean'  => 'No se pudo determinar la persona que desea agregar, intente nuevamente',
        ];
    }
}
