<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = ['reservation_room_id', 'visit_date', 'left_at'];

    public $timestamps = false;

    public function reservation()
    {
        return $this->hasOneThrough('App\Reservation', 'App\ReservationRoom');
    }

    public function visitors()
    {
        return $this->belongsToMany('App\People',
         'visitors', 'visit_id' , 'person_id')
         ->using('App\Visitor')->withPivot('id');
    }

    

}
