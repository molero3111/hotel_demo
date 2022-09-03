<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentService extends Model
{
    protected $fillable = ['service'];

    public $timestamps = false;
}
