<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('units_test','App\Http\Controllers\DataImportController@importUnits');

/*Route::get('states', function (){
    return \App\Models\State::with(['cities','country'])->paginate(5);
});*/
/*Route::get('role_test', function (){
    $user = \App\Models\User::find(75);
    return $user->roles;
});*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['register'=>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*Route::get('test_email',function (){
    return 'hello';
})->middleware(['auth','user_is_admin','user_is_support']);*/

Route::group(['auth', 'user_is_admin'], function () {
    //units
    Route::get('units', '\App\Http\Controllers\UnitController@index')->name('units');
    Route::post('units', '\App\Http\Controllers\UnitController@store');
    Route::delete('units', '\App\Http\Controllers\UnitController@delete');
    Route::PUT('units', '\App\Http\Controllers\UnitController@put');
    Route::get('search-units/', '\App\Http\Controllers\UnitController@search')->name('search-units');
    //customers


    //categories
    Route::get('categories', '\App\Http\Controllers\CategoryController@index')->name('categories');
    Route::post('categories', '\App\Http\Controllers\CategoryController@store');
    Route::delete('categories', '\App\Http\Controllers\CategoryController@delete');
    Route::put('categories', '\App\Http\Controllers\CategoryController@put');
    Route::get('search-categories/', '\App\Http\Controllers\CategoryController@search')->name('search-categories');
    //Products
    Route::get('products', '\App\Http\Controllers\ProductController@index')->name('products');
    Route::get('new-product/{id?}', '\App\Http\Controllers\ProductController@newProduct')->name('new-product');
    Route::post('new-product', '\App\Http\Controllers\ProductController@store');
    Route::post('delete-image', '\App\Http\Controllers\ProductController@deleteImage')->name('delete-image');

    Route::get('update-product/{id}', '\App\Http\Controllers\ProductController@newProduct')->name('update-product-form');

    Route::put('update-product', '\App\Http\Controllers\ProductController@update')->name('update-product');
    Route::delete('products/{id}', '\App\Http\Controllers\ProductController@delete');
    //tags
    Route::get('tags', '\App\Http\Controllers\TagController@index')->name('tags');
    Route::post('tags', '\App\Http\Controllers\TagController@store');
    Route::delete('tags', '\App\Http\Controllers\TagController@delete');
    Route::PUT('tags', '\App\Http\Controllers\TagController@put');
    Route::get('search-tags/', '\App\Http\Controllers\TagController@search')->name('search-tags');


    //orders
    //payments
    //shipments


    //countries
    Route::get('countries', '\App\Http\Controllers\CountryController@index')->name('countries');
    //cities
    Route::get('cities', '\App\Http\Controllers\CityController@index')->name('cities');
    //states
    Route::get('states', '\App\Http\Controllers\StateController@index')->name('states');


    //reviews
    Route::get('reviews', '\App\Http\Controllers\ReviewController@index')->name('reviews');

    //tickets
    Route::get('tickets', '\App\Http\Controllers\TicketController@index')->name('tickets');

    //roles
    Route::get('roles', '\App\Http\Controllers\RoleController@index')->name('roles');
});



