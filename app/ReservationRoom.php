<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReservationRoom extends Pivot
{
    protected $fillable = ['reservation_id', 'room_id'];

    protected $table = 'reservation_rooms';

    public function room(){
        return $this->belongsTo('App\Room');
    }

    public function reservation(){
        return $this->belongsTo('App\Reservation');
    }

}
