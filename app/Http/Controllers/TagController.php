<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::simplePaginate(env('PAGINATION',16));
        return view('admin.tags.tags')->with(['tags'=>$tags]);
    }
}
