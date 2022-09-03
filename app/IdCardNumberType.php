<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdCardNumberType extends Model
{
    protected $fillable = ['abbreviation'];

    protected $table= 'id_card_number_types';

    public function people(){
        return $this->hasMany('App\People');
    }
}
