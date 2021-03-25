<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $products = Product::with(['category','images'])->simplePaginate(env('PAGINATION',16));
        $currency = env("CURRENCY_CODE","$");
        return view('admin.products.products')->with(['products' => $products,'currency'=>$currency]);
    }
}
