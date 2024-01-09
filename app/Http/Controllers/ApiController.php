<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Qualification;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //get all cities
    public function index($province_id)
    {
        $cities = City::where('province_id', $province_id)->get()->pluck('name', 'id');

        return response()->json([
            'success' => true,
            'cities' => $cities
        ]);
    }

    public function qualifications($profession_id)
    {
        $qualifications = Qualification::where('profession_id', $profession_id)->get()->pluck('name', 'id');

        return response()->json([
            'success' => true,
            'qualifications' => $qualifications
        ]);
    }

}
