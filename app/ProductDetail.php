<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $fillable = ['payment_id', 'product_id', 'units', 'consumed_at',
    'created_at', 'price'];
    
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\Product');
    }

    public function payment(){
        return $this->belongsTo('App\Payment');
    }
}
