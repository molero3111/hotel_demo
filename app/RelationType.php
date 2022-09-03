<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RelationType extends Model
{
    protected $fillable = ['type', 'is_underage_adult_relation'];
    public $timestamps = false;
}
