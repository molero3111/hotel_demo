<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    // protected $fillable = ['id', 'sortname', 'name', 'phone_code'];
    public $timestamps = false;

    //a country has many regions
    public function regions(){
        return $this->hasMany('App\Region');//
    }
}
