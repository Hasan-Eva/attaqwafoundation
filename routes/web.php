<?php

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

Route::get('/', function () {
   return view('welcome');
	//return view('frontend.pages.home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::get('/frontend', function () {
   //return view('welcome');
	return view('frontend.pages.home');
})->name('frontend.home')->middleware('auth');
//Route::get('/get-color', [App\Http\Controllers\Auth\DefaultController::class, 'get_color'])->name('get-color')->middleware('auth');


//API Route
Route::group(['namespace'=>'App\Http\Controllers\Auth', 'middleware'=>'auth'], function () {
	Route::get('/get-subcategory', 'DefaultController@get_subcategory')->name('get-subcategory');
	Route::get('/get-brand', 'DefaultController@get_brand')->name('get-brand');
	Route::get('/get-color', 'DefaultController@get_color')->name('get-color');
	Route::get('/get-size', 'DefaultController@get_size')->name('get-size');
	Route::get('/get-rate', 'DefaultController@get_rate')->name('get-rate');
	Route::get('/get-stock', 'DefaultController@get_stock')->name('get-stock');
	Route::get('/get-stock_qty', 'DefaultController@get_stock_size')->name('get-stock_size');
	Route::get('/get-stock_color', 'DefaultController@get_stock_color')->name('get-stock_color');
	
	Route::get('/get-courier-charge', 'DefaultController@get_courier_charge')->name('get-courier-charge');
	Route::get('/get-advance-avail', 'DefaultController@get_advance_avail')->name('get-advance-avail');
	Route::get('/get-unit_stock', 'DefaultController@get_unit_stock')->name('get-unit-stock');
	Route::get('/get-order-qantity', 'DefaultController@get_order_qantity')->name('get-order-qantity');
	Route::get('/get-unit_name', 'DefaultController@get_unit_name')->name('get-unit-name');
	Route::get('/get-unit_price', 'DefaultController@get_unit_price')->name('get-unit-price');
	Route::get('/get-total_price', 'DefaultController@get_total_price')->name('get-total-price');
	
	Route::get('/get-order', 'DefaultController@get_order')->name('get-order');
	Route::get('/get-product', 'DefaultController@get_product')->name('get-product');
	
	Route::get('/get-cleaner', 'DefaultController@get_cleaner')->name('get-cleaner');
});
