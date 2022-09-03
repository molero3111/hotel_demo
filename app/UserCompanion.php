<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;



class UserCompanion extends Pivot
{ 
    use SoftDeletes;

    protected $fillable = ['user_id', 'id_card_number_type_id', 'relation_type_id', 'id_number',
    'name', 'lastname', 'phone_number', 'email', 'address', 'created_at',
    'deleted_at', 'birth_date'];

    protected $table = 'user_companions';

    public $timestamps = false;

    public function relation_type(){
        return $this->belongsTo('App\RelationType');
    }

    // public function person(){
    //     return $this->belongsTo('App\People');
    // }

     public function id_number_type(){
        return $this->belongsTo('App\IdCardNumberType', 'id_card_number_type_id');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

}
