<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Interest;
use Auth;
use Ixudra\Geo\Facades\Geo;

class SearchController extends Controller
{
    public function filter(Request $request, User $user)
    {
        $temp = DB::table('users')->join('usersInterests', 'users.id', '=', 'usersInterests.userid')->leftJoin('interests', 'interests.id', '=', 'usersInterests.interestid')->get();
        if ($request->sport != 'Any') {
            $temp = $temp->where('interestid', $request->sport);
            if ($request->level != 'Any') {
                $temp = $temp->where('interestid', $request->sport)
                                ->where('level', $request->level);
            }
        }
        //VARS
        $slider = $request->slider * 1000;
        $filtered = Array();
        $filters = $temp;
        $user = Auth::User();
        $street = $user->street;
        $zipcode = $user->zipcode;
        $city = $request->city;
        $address = $street . ", " . $zipcode . " " . $city;
        //
        foreach($filters as $filter) {
            $distance = Geo::distance($address, 
                                      $filter->street . ", " . $filter->zipcode . " " . $filter->city);
            if ($distance->distance <= $slider) {
                array_push($filtered, $filter);
            }
        }
        //dd($filters);
        $users = User::all();
        $interests = Interest::all();
        return view('users.show', compact('users', 'interests', 'filtered'));
    }

    public function geofilter(Request $request, User $user)
    {
        $radius = 100; // radius of bounding circle in kilometers
        $EMR = 6371; // earth's mean radius, km
        //$EMR = 3959; // earth's mean radius, miles
        $user = Auth::user();
        $lat = $user->lat;
        $lon = $user->lon;
        // first-cut bounding box (in degrees)
        $maxLat = $lat + rad2deg($radius/$EMR);
        $minLat = $lat - rad2deg($radius/$EMR);
        // compensate for degrees longitude getting smaller with increasing latitude
        $maxLon = $lon + rad2deg($radius/$EMR/cos(deg2rad($lat)));
        $minLon = $lon - rad2deg($radius/$EMR/cos(deg2rad($lat)));

        $sql = '
            SELECT *, (ATAN2(SQRT(POWER(COS(RADIANS(lat)) * SIN(RADIANS(lon-:lon)), 2) + 
            POWER(COS(RADIANS(:lat)) *SIN(RADIANS(lat)) - 
            (SIN(RADIANS(:lat2)) * COS(RADIANS(lat)) * COS(RADIANS(lon-:lon2))), 2)), 
            SIN(RADIANS(:lat3)) * SIN(RADIANS(lat)) + 
            COS(RADIANS(:lat4)) * COS(RADIANS(lat)) * COS(RADIANS(lon-:lon3))) * :EMR) AS distance
                FROM (
                    SELECT * FROM items WHERE lat BETWEEN :minLat 
                    AND :maxLat AND lon BETWEEN :minLon AND :maxLon 
                    // any other filters you want to add
                ) AS FirstFilter
            HAVING distance < :radius 
                ORDER BY distance 
            LIMIT 0, 20';

        $params = [
            'lon' => $lon,
                'lat' => $lat,
                'lat2' => $lat,// Repeated values not allowed so increment them in the params array
                'lon2' => $lon,
                'lat3' => $lat,
                'lat4' => $lat,
                'lon3' => $lon,
            'EMR' => $EMR, 
            'minLat' => $minLat, 
            'maxLat' => $maxLat, 
            'minLon' => $minLon, 
            'maxLon' => $maxLon, 
            'radius' => $radius,
        ];

        $results = DB::select(DB::raw($sql), $params);
        dd($results);
        //return Model::hydrate($results);
    }
}
