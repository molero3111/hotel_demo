<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\VerifyMailExistence;

class ProfileUpdateRequest extends FormRequest
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
        $fieldName= $this->request->get('fieldName');
        if($fieldName=='id_number'){
            return [
                'fieldValue' => ['bail','required', 'string', 'max:20','regex:/^[-0-9]{8,20}$/'],
                'id_number_type' => ['bail','required', 'string', 'max:3','exists:App\IdCardNumberType,abbreviation']
                ];
        }else if($fieldName=='name' || $fieldName=='lastname'){
            return [
                'fieldValue' => ['bail', 'required',  'string', 'max:40'],
                ];
        }else if($fieldName=='locality_id'){
            return [
                'fieldValue' => ['bail','required', 'string', 'max:100', 'exists:App\Locality,name'],
                ];
        }else if($fieldName=='address'){
            return [
                'fieldValue' => ['nullable','max:150', 'regex:/^[^<>?\/\\|\|{}\[\]\+\=&\^%\$@!`~]{2,150}$/'],
                ];
        }else if($fieldName=='phone_number'){
            return [
                'fieldValue' => ['nullable','max:30','regex:/^[0-9\+\(\)\- ]{8,30}$/'],
                ];
        }else if($fieldName=='birth_date'){
             $limitDate = date("d-m-Y", strtotime(date("d-m-Y") . " - 18 year"));
            return [
                'fieldValue' => ['bail','required','date', 'before_or_equal:'.$limitDate],
                ];
        }else if($fieldName=='email'){
            return [
                'fieldValue' => ['bail','required', 'string', 'email', 'max:100', new VerifyMailExistence],
                ];
        }else {
            return [
                'fieldValue' => ['bail','required', 'string', 'min:8', 'max:40', 'confirmed']
                ];
        }
    }
    public function attributes()
    {   
        $fieldName= $this->request->get('fieldName');

        if($fieldName=='id_number'){
            return [
                'fieldValue' => 'n??mero de identificaci??n',
                'id_number_type' => 'tipo de identificaci??n',
                ];
        }else if($fieldName=='name'){
            return [
                'fieldValue' => 'nombre',
                ];
        }else if ($fieldName=='lastname'){
            return [
                'fieldValue' => 'apellido',
                ];
        }else if($fieldName=='locality_id'){
            return [
                'fieldValue' => 'ciudad',
                ];
        }else if($fieldName=='address'){
            return [
                'fieldValue' => 'direcci??n',
                ];
        }else if($fieldName=='phone_number'){
            return [
                'fieldValue' => 'n??mero de tel??fono',
                ];
        }else if($fieldName=='birth_date'){
            return [
                'fieldValue' => 'fecha de nacimiento',
                ];
        }else if($fieldName=='email'){
            return [
                'fieldValue' => 'correo',
                ];
        }else if($fieldName=='password'){
            return [
                'fieldValue' => 'contrase??a',
                ];
        }
    }
}
