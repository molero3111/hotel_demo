<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = ['bank_id', 'number',
    'balance', 'is_primary_account'];

    public $timestamps = false;

    public function bank(){
        return $this->belongsTo('App\Bank');
    }
}
