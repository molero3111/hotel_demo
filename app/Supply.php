<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $fillable = ['name', 'in_stock',
    'cost'];
    
    public $timestamps = false;

    public function product(){
        return $this->HasOne('App\Product');
    }
}
