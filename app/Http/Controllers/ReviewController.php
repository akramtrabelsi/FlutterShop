<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(){
        $reviews = Review::with(['product','customer'])->simplePaginate(env('PAGINATION',16));
        return view('admin.reviews.reviews')->with(['reviews'=>$reviews]);
    }
}
