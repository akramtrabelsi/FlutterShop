<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::simplePaginate(env('PAGINATION',16));
        return view('admin.categories.categories')->with(['categories' => $categories, 'showLinks' => true,
        ]);
    }
    private function categoryNameExists($categoryName)
    {
        $category = Category::where(
            'name', '=', $categoryName
        )->get();
        if (count($category) > 0) {
            return true;
        }
        return false;
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'category_image' => 'required',
            'image_direction' => 'required',
        ]);
        $categoryName = $request->input('category_name');
        if ($this->categoryNameExists($categoryName)) {
            Session::flash('message', 'category name already exists');
            return back();
        }

        $category = new Category();
        $category->name = $categoryName;
        $category->image_direction = $request->input('image_direction');
        if ($request->hasFile('category_images')) {
            $image = $request->file('category_images');
            $path = $image->store('public');
            $category->image_url = $path;
        }
        $category->save();

        Session::flash('message', 'Category has been added');
        return back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'category_name' => 'required'
        ]);
        $categoryname = $request->input('category_name');
        $categoryID = $request->input('category_id');
        if ($this->categoryNameExists($categoryname)) {
            Session::flash('message', 'Category name already exist');
            return back();
        }

        $category = Category::find($categoryID);
        $category->name = $categoryname;
        $category->save();
        Session::flash('message', 'Category has been updated');
        return back();

    }

    public function delete(Request $request)
    {
        $request->validate([
            'category_id' => 'required'
        ]);
        $catID = $request->input('category_id');
        Category::destroy($catID);
        Session::flash('message', 'Category has been deleted');
        return back();
    }

    public function search(Request $request)
    {
        $request->validate([
            'category_search' => 'required'
        ]);

        $searchTerm = $request->input('category_search');

        $categories = Category::where(
            'name', 'LIKE', '%' . $searchTerm . '%'

        )->get();

        if (count($categories) > 0) {
            return view('admin.categories.categories')->with([
                'categories' => $categories,
                'showLinks' => false,
            ]);
        }
        Session::flash('message', 'Nothing Found!!!');
        return redirect()->back();
    }
}
