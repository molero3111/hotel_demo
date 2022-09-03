<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['supply_id', 'price'];
    
    public $timestamps = false;

    public function supply(){
        return $this->belongsTo('App\Supply');
    }
}
