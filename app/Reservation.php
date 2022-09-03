<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['user_id', 'check_in','check_out', 'verified_at', 'created_at'];

    public $timestamps = false;

    // protected $dates = ['check_in', 'check_out', 'verified_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function companions()
    {
        return $this->belongsToMany('App\UserCompanion', 
        'reservation_companions', 'reservation_id', 'user_companion_id')
        ->using('App\ReservationCompanion')
        ->withPivot('id', 
         'created_at', 'verified_at');
    }

    public function underages()
    {
       
        return $this->belongsToMany('App\Underage', 
        'reservation_underages', 'reservation_id', 'underage_id')
        ->using('App\ReservationUnderage')
        ->withPivot('id', 'created_at', 'verified_at');
    }

    public function rooms()
    {
       
       return $this->belongsToMany('App\Room', 
       'reservation_rooms', 'reservation_id', 'room_id')
       ->using('App\ReservationRoom')->withPivot('id');
    }

    public function payments(){
        return $this->hasMany('App\Payment');
    }

    
}
