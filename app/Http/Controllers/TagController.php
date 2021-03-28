<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    public function index(){
        $tags = Tag::simplePaginate(env('PAGINATION',16));
        return view('admin.tags.tags')->with(['tags'=>$tags, 'showLinks'=>true,]);
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
    public function search(Request $request)
    {
        $request->validate([
            'tag_search'=>'required'
        ]);

        $searchTerm=$request->input('tag_search');

        $tags=Tag::where(
            'tag' , 'LIKE','%'.$searchTerm.'%'
        )->get();

        if(count($tags)>0){
            return view('admin.tags.tags')->with([
                'tags'=>$tags,
                'showLinks'=>false,
            ]);
        }
        Session::flash('message','Nothing Found!!!');
        return redirect()->back();
    }

    public function put(Request $request)
    {
        $request->validate([
            'tag_id' => 'required',
            'tag_name' => 'required'
        ]);
        $tagName = $request->input('tag_name');

        if (! $this->tagNameExists($tagName)){
            return redirect()->back();
        }

        $tagID = intval($request->input('tag_id'));

        $tag = Tag::find($tagID);

        $tag->tag = $request->input('tag_name');
        $tag->save();
        Session::flash('message', 'Tag ' . $tag->tag . ' has been updated');
        return redirect()->back();
    }
    public function delete(Request $request){
        if(is_null($request->input('tag_id'))||empty($request->input('tag_id'))){
            $request->flash('message', 'tag ID is required');
            return redirect()->back();
        }
        $id = $request->input('tag_id');
        Tag::destroy($id);
        Session::flash('message','Tag has been deletes');
        return redirect()->back();
    }
}

