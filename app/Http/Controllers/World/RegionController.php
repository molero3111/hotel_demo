<?php

namespace App\Http\Controllers\World;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Region;
use App\Http\Requests\RegionLocalitiesRequest;

class RegionController extends Controller
{
    public function getRegionLocalities(RegionLocalitiesRequest $request){
       
        $validated = $request->validated();

        $region = Region::where('name', $request->region)->first();
        $localities = $region->localities;

        //remember to delete test country !
        for ($i=0; $i < count($localities); $i++) { 
            $localities[$i]=$localities[$i]->name;
        }
        return $localities;
    }

    
}
