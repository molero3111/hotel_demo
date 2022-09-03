<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Country;

class DataExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $data = Country::where('name', $value)->first();
        if(!$data){
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
        return 'El valor ingresado en el campo :attribute no existe en nuestros registros.';
    }
}
