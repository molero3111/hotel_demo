<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FirstCapitalLetter implements Rule
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
        return ucfirst($value) === $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La primera letra del campo :attribute debe estar en mayuscula.';
    }
}
