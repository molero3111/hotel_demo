<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolymorphicLog extends Model
{
    protected $fillable = [
        'transaction_id', 'table_name_id', 'user_id', 
        'record_id', 'data'];

    
}
