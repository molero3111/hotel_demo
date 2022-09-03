<?php

namespace App\Http\Requests\People;

use Illuminate\Foundation\Http\FormRequest;

class UserPeopleRequest extends FormRequest
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
        $limitDate = date("d-m-Y");
        return [
            'id_number_type' => ['bail','required', 'string', 'min:1', 'max:3','exists:id_card_number_types,abbreviation'],
            'id_number' => ['bail','required', 'string', 'max:20','regex:/^[0-9]{8,20}$/'],
            'name' => ['bail','required', 'string', 'max:40'],
            'lastname' => ['bail','required', 'string', 'max:40'],
            'address' => ['bail','nullable','max:150', 'regex:/^[^<>?\/\\|\|{}\[\]\+\=&\^%\$@!`~]{2,150}$/'],
            'phone_number' => ['bail','nullable','max:30','unique:people','regex:/^[0-9\+\(\)\- ]{8,30}$/'],
            'birth_date' => ['bail','required','date', 'before_or_equal:'.$limitDate],
            'email' => ['bail','nullable', 'string', 'email', 'max:100'],
            'relation_type'=>['bail', 'required', 'string', 'min:2', 'max:50', 'exists:relation_types,type']
        ];
    }
    public function attributes()
    {
        return [
            'id_number_type'=>'tipo de identificación',
            'id_number' => 'número de identificación',
            'name'=>'nombre',
            'lastname'=>'apellido',
            'address'=>'dirección',
            'phone_number'=>'télefono',
            'email'=>'correo',
            'birth_date'=>'fecha de nacimiento',
            'relation_type'=>'parentesco'
        ];
    }
}
