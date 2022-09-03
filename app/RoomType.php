<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = ['type', 'capacity',
    'price_per_day', 'additional_cost'];

    public $timestamps = false;

    public function rooms(){
        return $this->hasMany('App\Room');
    }
}
