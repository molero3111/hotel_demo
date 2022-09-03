<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id', 'user_role_id', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function person()
    {
        return $this->belongsTo('App\People');
    }

    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }

    public function companions()
    {
       
        return $this->belongsToMany('App\People', 
        'user_companions', 'user_id', 'person_id')
        ->using('App\UserCompanion')
        ->withPivot('id', 'relation_type_id', 'created_at', 'verified_at');
    }

    public function underages()
    {
       
        return $this->belongsToMany('App\People', 
        'underages', 'user_id', 'person_id')
        ->using('App\Underage')
        ->withPivot('id', 'relation_type_id', 'has_legal_custody', 'verified_at');
    }

}
