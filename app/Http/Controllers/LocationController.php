<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Ixudra\Geo\Facades\Geo;

class LocationController extends Controller
{
    public function updateLocation() 
    {
    	$test = Geo::geocode("Barbarastraat 2, 3120 Tremelo");
    	var_dump($test);
    }
}
