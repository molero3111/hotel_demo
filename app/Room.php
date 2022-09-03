<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['room_number', 'room_type_id', 'room_status_id'];

    public $timestamps = false;

    public function type(){
        return $this->belongsTo('App\RoomType', 'room_type_id');
    }

    public function status(){
        return $this->belongsTo('App\RoomStatus', 'room_status_id');
    }

    public function reservations()
    {
        //return $this->hasManyThough('App\Reservation','App\ReservationRoom');
        return $this->belongsToMany('App\Reservation', 
       'reservation_rooms', 'room_id', 'reservation_id')
       ->using('App\ReservationRoom');
    }

    public function visits()
    {
        return $this->hasManyThrough('App\Visit','App\ReservationRoom',
        'room_id', 'reservation_room_id', 'id', 'id');
    }
}
