<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name', 'iso_code_abbreviation', 
    'symbol','dollar_equivallent'];

    public $timestamps= false;
}
