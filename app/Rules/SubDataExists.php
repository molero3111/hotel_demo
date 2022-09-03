<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Country;

class SubDataExists implements Rule
{
    private $attribute;
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
        $this->attribute=$attribute;
        $property='';
        $parentData = ('App\\'. ucfirst($attribute))::where('name', $value)->first();

        /**determine model property */

        if($attribute=='country'){ $property = 'regions'; }
        else if($attribute=='region'){ $property = 'localities'; }

        $childrenData = $parentData->$property;
        if(!$childrenData || count($childrenData) < 1){
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
        $subRecords='';
        if($this->attribute=='country'){$subRecords='estados';}
        else if($this->attribute=='region'){$subRecords='ciudades';}
        return 'El :attribute seleccionado no tiene '. $subRecords .'.';
    }
}
