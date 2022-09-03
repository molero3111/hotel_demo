<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankMovement extends Model
{
    protected $fillable = ['payment_id', 'bank_account_id', 
    'payment_type_id', 'accountable_code', 'total', 
    'reference_number', 'paid_at', 'movement_currency_id'];

    public $timestamps = false;

    public function payment_type(){
        return $this->belongsTo('App\PaymentType');
    }

    public function bank_account(){
        return $this->belongsTo('App\BankAccount');
    }

    public function payment(){
        return $this->belongsTo('App\Payment');
    }
}
