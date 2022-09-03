<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Underage extends Pivot
{
    protected $fillable = ['user_id', 'person_id',
    'relation_type_id', 'has_legal_custody', 'verified_at'];

    protected $table = 'underages';

    public function relation_type(){
        return $this->belongsTo('App\RelationType');
    }

    public function person(){
        return $this->belongsTo('App\People');
    }
}
