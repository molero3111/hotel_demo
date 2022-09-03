<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['reservation_id', 
    'payment_service_id', 'total',];


    public $timestamps = false;

    public function reservation(){
        return $this->belongsTo('App\Reservation');
    }

    public function payment_service(){
        return $this->belongsTo('App\PaymentService');
    }

    public function bank_movements(){
        return $this->hasMany('App\BankMovement');
    }
}
