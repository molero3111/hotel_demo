<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FirstCapitalLetter;
use App\Rules\SubDataExists;

class RegionLocalitiesRequest extends FormRequest
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
            'region' => ['bail','required','max:50','min:2',
            new FirstCapitalLetter, 'exists:App\Region,name',
            new SubDataExists]
          
        ];
    }

    public function attributes()
    {
        return [
            'region' => 'estado',
        ];
    }
}
