<?php

namespace App\Http\Requests\Rooms;

use Illuminate\Foundation\Http\FormRequest;

class RoomTypeRequest extends FormRequest
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
    public function rules() {
        return [
            'type' => ['bail','required','max:50','min:5', 'exists:App\RoomType,type']
        ];
    }

     public function attributes() {
        return [
            'type' => 'tipo de habitación',
        ];
    }
}
