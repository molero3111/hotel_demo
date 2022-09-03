<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['currency_id', 'name', 'currency_id', 'abbreviation'];

    public $timestamps = false;

    public function currency(){
        return $this->belongsTo('App\Currency');
    }
}
