<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index(){
        $states = State::with(['country'])->simplePaginate(env('PAGINATION',16));
        return view('admin.states.states')->with(['states'=>$states]);
    }
}
