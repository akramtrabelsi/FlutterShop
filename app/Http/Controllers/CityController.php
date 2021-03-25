<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){
        $cities = City::with(['states','country'])->simplePaginate(env('PAGINATION',16));
        return view('admin.cities.cities')->with(['cities'=>$cities]);
    }
}
