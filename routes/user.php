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

Route::group(['namespace'=>'App\Http\Controllers\User', 'middleware'=>'auth'], function () {	
	Route::prefix('electricity')->name('electricity.')->group(function(){
			Route::get('/view', 'UserController@index')->name('view');
			Route::post('/store', 'UserController@store')->name('store');
			Route::post('/edit', 'UserController@edit')->name('edit');
			Route::post('/update', 'UserController@update')->name('update');
			
			Route::post('/bills', 'UserController@bills')->name('bills');
			Route::post('/reading', 'UserController@reading')->name('reading');
			Route::post('/lttr', 'UserController@lttr')->name('lttr');
			
			Route::post('/metter', 'UserController@metter')->name('metter');
			
			Route::get('/view1', 'UserController@index1')->name('view1');
			
	});
	Route::prefix('occupant')->name('occupant.')->group(function(){
			Route::get('/view', 'OccupantController@occupant_view')->name('view');
			
			// execute
			Route::get('/orderupdate/{id}', 'UserController@order_update')->name('order_update');
			
			Route::get('/productdelete/{id}', 'UserController@product_deactive')->name('product_delete');
			Route::get('/productactive/{id}', 'UserController@product_active')->name('product_active');
			// Edit with ajax
			Route::get('/productedit/{id}', 'UserController@product_edit')->name('productedit');
			Route::post('/productupdate', 'UserController@product_update')->name('productupdate');
	});
	Route::prefix('ownner')->name('ownner.')->group(function(){
			Route::post('/view', 'OwnerController@view')->name('view');
	});
	Route::prefix('invoice')->name('invoice.')->group(function(){
			Route::get('/full_invoice/{id}', 'UserController@full_invoice')->name('full_invoice');
	});
	
	Route::group(['prefix' => 'report'], function(){
  		Route::get('/summery_index', 'ReportController@index')->name('summery.index');
		Route::post('/summery_view', 'ReportController@summery_view')->name('summery.view');
		
		Route::get('/saving_mode', 'ReportController@saving_mode')->name('saving.mode');
		Route::post('/saving_mode', 'ReportController@saving_mode_view')->name('saving.mode_view');
		
		Route::get('/loan_index', 'ReportController@loan_index')->name('loan.index');
		Route::post('/loan_index', 'ReportController@loan_mode_view')->name('loan.mode_view');
		
		Route::get('/client_index', 'ReportController@client_index')->name('client.index');
		Route::post('/client_index', 'ReportController@client_mode_view')->name('client_mode.view');
		
		Route::get('/affairs_index', 'ReportController@affairs_index')->name('affairs.index');
		Route::post('/affairs_index', 'ReportController@affairs_view')->name('affairs.view');
		Route::get('/cash_book_index', 'ReportController@cash_book_index')->name('cash_book.index');
		Route::post('/cash_book_index', 'ReportController@cash_book_view')->name('cash_book.view');
	});
});