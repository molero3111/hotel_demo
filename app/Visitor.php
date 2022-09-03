<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Visitor extends Pivot
{
    protected $fillable = ['visit_id', 'person_id'];

}
