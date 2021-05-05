<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::simplePaginate(env('PAGINATION',16));
        return view('admin.categories.categories')->with(['categories'=>$categories, 'showLinks'=>true,]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'category_name' => 'required',
        ]);
        $categoryName = $request->input('category_name');

        if (! $this->categoryNameExists($categoryName)){
            return redirect()->back();
        }

        $category = new Category();

        $category->name = $request->input('category_name');
        $category->save();
        Session::flash('message', 'Category '.$category->name. ' has been added' );
        return redirect()->back();


    }
    private function categoryNameExists($categoryName)
    {
        $category = Category::where(
            'category', '=', $categoryName
        )->first();
        if (!is_null($category)) {
            Session::flash('message', 'Category Name(' . $categoryName . ') already exists');
            return false;


        }
        return true;
    }
    public function search(Request $request)
    {
        $request->validate([
            'category_search'=>'required'
        ]);

        $searchTerm=$request->input('category_search');

        $categories=Category::where(
            'category' , 'LIKE','%'.$searchTerm.'%'
        )->get();

        if(count($categories)>0){
            return view('admin.categories.categories')->with([
                'categories'=>$categories,
                'showLinks'=>false,
            ]);
        }
        Session::flash('message','Nothing Found!!!');
        return redirect()->back();
    }

    public function put(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'category_name' => 'required'
        ]);
        $categoryName = $request->input('category_name');

        if (! $this->categoryNameExists($categoryName)){
            return redirect()->back();
        }

        $categoryID = intval($request->input('category_id'));

        $category = Category::find($categoryID);

        $category->name = $request->input('category_name');
        $category->save();
        Session::flash('message', 'Category ' . $category->name . ' has been updated');
        return redirect()->back();
    }
    public function delete(Request $request){
        if(is_null($request->input('category_id'))||empty($request->input('category_id'))){
            $request->flash('message', 'Category ID is required');
            return redirect()->back();
        }
        $id = $request->input('category_id');
        Category::destroy($id);
        Session::flash('message','Category has been deletes');
        return redirect()->back();
    }
}
