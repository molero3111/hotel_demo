<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReservationUnderage extends Pivot
{
    protected $fillable = ['underage_id', 'reservation_id',
    'verified_at'];

    protected $table = 'reservation_underages';
}
