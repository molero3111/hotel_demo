<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    // protected $fillable = ['id', 'region_id', 'name'];
    public $timestamps = false;

    public function people(){
        return $this->hasMany('App\People');
    }

    public function region(){
        return $this->belongsTo('App\Region');
    }
}
