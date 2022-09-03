<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolymorphicVerificationCode extends Model
{
    protected $fillable = ['table_name_id', 'user_id',
    'record_id', 'code'];
}
