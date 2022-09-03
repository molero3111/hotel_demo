<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'created_at'];
    
    public $timestamps = false;

    // public function product(){
    //     return $this->belongsTo('App\Product');
    // }
}
