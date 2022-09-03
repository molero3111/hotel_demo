<?php

namespace App\Http\Controllers\World;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Country;
use App\Http\Requests\CountryRegionRequest;

class CountryController extends Controller
{
    public function getCountryRegions(CountryRegionRequest $request){

        $validated = $request->validated();
        
        $country = Country::where('name', $request->country)->first();

        $regions = $country->regions;

        for ($i=0; $i < count($regions) ; $i++) { 
            $regions[$i]=$regions[$i]->name;
        }
        //remember to delete test country !
        return  $regions;
    }
}
