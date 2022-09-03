<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FirstCapitalLetter;
use App\Rules\SubDataExists;

class CountryRegionRequest extends FormRequest
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
            'country' => ['bail','required','max:50','min:2',
            new FirstCapitalLetter, 'exists:App\Country,name',
            new SubDataExists]
          
        ];
    }

    public function attributes()
    {
        return [
            'country' => 'país',
        ];
    }
}
