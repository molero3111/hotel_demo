<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
class ReservationCompanion extends Pivot
{
    protected $fillable = ['user_companion_id', 'reservation_id'];

    protected $table = 'reservation_companions';
}
