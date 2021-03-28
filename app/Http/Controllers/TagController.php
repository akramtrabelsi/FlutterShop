<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::simplePaginate(env('PAGINATION',16));
        return view('admin.tags.tags')->with(['tags'=>$tags]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'tag_name' => 'required',
        ]);
        $tagName = $request->input('tag_name');

        if (! $this->tagNameExists($tagName)){
            return redirect()->back();
        }

        $tag = new Tag();

        $tag->tag = $request->input('tag_name');
        $tag->save();
        Session::flash('message', 'Tag '.$tag->tag. ' has been added' );
        return redirect()->back();


    }
    private function tagNameExists($tagName)
    {
        $tag = Tag::where(
            'tag', '=', $tagName
        )->first();
        if (!is_null($tag)) {
            Session::flash('message', 'Tag Name(' . $tagName . ') already exists');
            return false;


        }
        return true;
    }
}

