<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('verified');

        $this->middleware('CheckAdmin');
        
    }

    public function get_admin_panel(){ return view('admin.admin'); }

    public function get_admin_currencies(){ return view('admin.finances.currencies'); }

    public function get_admin_banks(){ return view('admin.finances.banks'); }

    public function get_admin_bank_accounts(){ return view('admin.finances.bank_accounts'); }

    public function get_hotel_supplies(){ return view('admin.supplies.supplies'); }

}
