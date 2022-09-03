<?php

namespace App\Http\Controllers\Reservations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationRoomController extends Controller
{
      
    /**this controller will be used to manage the additional rooms a user decides to add to a
     * reservation
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('verified');
    }

    public function storeReservationRoom (){
        
    }
}
