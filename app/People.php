<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    protected $fillable = [
        'locality_id', 'id_card_number_type_id', 'id_number',
        'name','lastname', 'address', 'phone_number',
        'birth_date'
    ];

    protected $dates = [
        'birth_date'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'person_id');
    }

    public function id_number_type(){
        return $this->belongsTo('App\IdCardNumberType', 'id_card_number_type_id', 'id');
    }
    public function locality(){
        return $this->belongsTo('App\Locality');
    }

    public function companions()
    {
        return $this->hasMany('App\Companion');
    }

    public function visits()
    {
        return $this->belongsToMany('App\Visit',
         'visitors', 'person_id' , 'visit_id')
         ->using('App\Visitor')->withPivot('id');
    }


}
