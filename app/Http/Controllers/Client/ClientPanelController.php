<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientPanelController extends Controller
{
    public function get_products(){ return view('products.products'); }
}
