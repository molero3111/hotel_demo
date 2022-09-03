<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    // protected $fillable = ['id', 'country_id', 'name'];
    public $timestamps = false;

    //a region belongs to one country 
    public function country(){
        return $this->belongsTo('App\Country');
    }

    //a region has many localities
    public function localities(){
        return $this->hasMany('App\Locality');
    }

    
}
