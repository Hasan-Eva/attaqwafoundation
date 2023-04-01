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

Route::get('check', function () {
    echo 'welcome';
})->middleware('admin');

Route::get('/admin', function () {
   //return view('welcome');
	return view('backend.pages.home');
})->name('admin.home')->middleware('admin');

Route::group(['namespace'=>'App\Http\Controllers\Admin', 'middleware'=>'admin'], function () {
	Route::group(['prefix' => 'admin'], function(){
  	//  Route::get('/admin/home', 'Admin\UsersController@view')->name('admin.home');
  		//Route::get('/admin/home', 'Admin\UsersController@view')->name('admin.home');
		
	});
	
	// For post
	Route::prefix('post')->name('post.')->group(function(){
			Route::get('/view', 'PostController@index')->name('view');
			Route::post('/store', 'PostController@store')->name('store');
			Route::get('/edit', 'PostController@staff_view')->name('edit');
			Route::post('/staff-edit', 'PostController@staff_update')->name('staff.update');
			// Edit with ajax
			//Route::get('/editstaff/{id}', 'PostController@editstaff')->name('edit');	
	});
	// For header
	Route::prefix('header')->name('header.')->group(function(){
			Route::get('/view', 'HeaderColler@index')->name('view');
			Route::get('/edit', 'HeaderColler@staff_view')->name('edit');
			Route::post('/update', 'HeaderColler@update')->name('update');
	});
	// For slider
	Route::prefix('slider')->name('slider.')->group(function(){
			Route::get('/view', 'SliderColler@index')->name('view');
			Route::get('/edit', 'SliderColler@staff_view')->name('edit');
			Route::post('/update', 'SliderColler@update')->name('update');
	});
	// For Donation
	Route::prefix('donation')->name('donation.')->group(function(){
			Route::post('/store', 'DonationColler@store')->name('store');
			Route::get('/view', 'DonationColler@index')->name('view');
			Route::get('/edit', 'DonationColler@staff_view')->name('edit');
			Route::post('/update', 'DonationColler@update')->name('update');
	});
	
	// For Increment
	Route::prefix('personal_file')->name('personal_file.')->group(function(){
			// For Staff
			Route::get('/view', 'PersonalFileController@staff_view')->name('staff.view');
			Route::post('/staff-file-store', 'PersonalFileController@staff_file_store')->name('staff_file_store');
			// For Security Guard
			Route::get('/guard-view', 'PersonalFileController@guard_view')->name('guard.view');
			Route::post('/guard-file-store', 'PersonalFileController@guard_file_store')->name('guard_file_store');
			// For Cleaner
			Route::get('/cleaner-view', 'PersonalFileController@cleaner_view')->name('cleaner.view');
			Route::post('/cleaner-file-update', 'PersonalFileController@cleaner_file_update')->name('cleaner_file_update');
			Route::post('/cleaner-file-store', 'PersonalFileController@cleaner_file_store')->name('cleaner_file_store');
			
			// Edit with ajax
			Route::get('/pfstaff/{id}', 'PersonalFileController@pf_staff')->name('pfstaff');
			Route::get('/pfguard/{id}', 'PersonalFileController@pf_guard')->name('pfguard');
			Route::get('/pfcleaner/{id}', 'PersonalFileController@pf_cleaner')->name('pfcleaner');
	});
	// For Advance Staff
	Route::prefix('advance.staff')->name('advance.staff.')->group(function(){
			Route::get('/view', 'AdvanceController@staff_view')->name('view');
			Route::post('/store', 'AdvanceController@staff_store')->name('store');
			Route::post('/edit', 'AdvanceController@cleaner_update')->name('update');
			// Edit with ajax
			Route::get('/editcleaner/{id}', 'StaffController@editcleaner')->name('edit');	
	});
	// For Advance Cleaner
	Route::prefix('advance.cleaner')->name('advance.cleaner.')->group(function(){
			Route::get('/view', 'AdvanceController@cleaner_view')->name('view');
			Route::post('/store', 'AdvanceController@cleaner_store')->name('store');
			Route::post('/edit', 'AdvanceController@cleaner_update')->name('update');
			// Edit with ajax
			Route::get('/editcleaner/{id}', 'StaffController@editcleaner')->name('edit');	
	});
	// For Advance Guard
	Route::prefix('advance.guard')->name('advance.guard.')->group(function(){
			Route::get('/view', 'AdvanceController@guard_view')->name('view');
			Route::post('/store', 'AdvanceController@guard_store')->name('store');
			Route::post('/edit', 'AdvanceController@cleaner_update')->name('update');
			// Edit with ajax
			Route::get('/editcleaner/{id}', 'StaffController@editcleaner')->name('edit');	
	});
	// For Absent Staff
	Route::prefix('absent.staff')->name('absent.staff.')->group(function(){
			Route::get('/view', 'AbsentController@staff_view')->name('view');
			Route::post('/store', 'AbsentController@staff_store')->name('store');
			Route::post('/edit', 'AbsentController@cleaner_update')->name('update');
			// Edit with ajax
			Route::get('/editcleaner/{id}', 'StaffController@editcleaner')->name('edit');	
	});
	// For Absent Cleaner
	Route::prefix('absent.cleaner')->name('absent.cleaner.')->group(function(){
			Route::get('/view', 'AbsentController@cleaner_view')->name('view');
			Route::post('/store', 'AbsentController@cleaner_store')->name('store');
			Route::post('/edit', 'AbsentController@cleaner_update')->name('update');
			// Edit with ajax
			Route::get('/editcleaner/{id}', 'StaffController@editcleaner')->name('edit');	
	});
	// For Absent Guard
	Route::prefix('absent.guard')->name('absent.guard.')->group(function(){
			Route::get('/view', 'AbsentController@guard_view')->name('view');
			Route::post('/store', 'AbsentController@guard_store')->name('store');
			Route::post('/edit', 'AbsentController@cleaner_update')->name('update');
			// Edit with ajax
			Route::get('/editcleaner/{id}', 'StaffController@editcleaner')->name('edit');	
	});
	// For Leave Staff
	Route::prefix('leave.staff')->name('leave.staff.')->group(function(){
			Route::get('/view', 'LeaveController@staff_view')->name('view');
			Route::post('/store', 'LeaveController@staff_store')->name('store');
			Route::post('/application', 'LeaveController@application')->name('application');
			Route::post('/edit', 'AdvanceController@cleaner_update')->name('update');
			// Edit with ajax
			Route::get('/editcleaner/{id}', 'StaffController@editcleaner')->name('edit');
			// pdf 
			Route::post('/register', 'LeaveController@register')->name('register');
	});
	// For category
	Route::prefix('category')->name('category.')->group(function(){
			Route::get('/view', 'CategoryController@index')->name('view');
			Route::post('/store', 'CategoryController@store')->name('store');
			Route::get('/delete_client', 'CategoryController@destroy')->name('delete');
			// Edit with ajax
			Route::get('/edit', 'CategoryController@edit')->name('edit');
			Route::get('/update', 'CategoryController@update_client')->name('update');
			Route::get('/delete_view', 'ClientController@client_delete')->name('delete_view');
			
	});
	// For subcategory
	Route::prefix('subcategory')->name('subcategory.')->group(function(){
			Route::get('/view', 'SubcategoryController@index')->name('view');
			Route::post('/store', 'SubcategoryController@store')->name('store');
			Route::get('/delete_client', 'SubcategoryController@destroy')->name('delete');
			// Edit with ajax
			Route::get('/delete_view', 'SubcategoryController@client_delete')->name('delete_view');
			// Ajax update data for another blade
			Route::get('/edit/{id}', 'SubcategoryController@edit')->name('edit');
			Route::post('/update', 'SubcategoryController@update')->name('update');
	});
	// For Brand
	Route::prefix('brand')->name('brand.')->group(function(){
			Route::get('/view', 'BrandController@index')->name('view');
			Route::post('/store', 'BrandController@store')->name('store');
			Route::get('/delete_client', 'BrandController@destroy')->name('delete');
			// Edit with ajax
			Route::get('/edit', 'BrandController@edit')->name('edit');
			Route::get('/update', 'BrandController@update_client')->name('update');
	});
	// For color 
	Route::prefix('color')->name('color.')->group(function(){
			Route::get('/view', 'ColorController@index')->name('view');
			Route::post('/store', 'ColorController@store')->name('store');
			Route::get('/delete_client', 'ColorController@destroy')->name('delete');
			// Edit with ajax
			Route::get('/edit', 'ColorController@edit')->name('edit');
			Route::get('/update', 'ColorController@update')->name('update');
			Route::get('/delete_view', 'ColorController@client_delete')->name('delete_view');
	});
	// For size 
	Route::prefix('size')->name('size.')->group(function(){
			Route::get('/view', 'SizeController@index')->name('view');
			Route::post('/store', 'SizeController@store')->name('store');
			Route::get('/delete_client', 'SizeController@destroy')->name('delete');
			// Edit with ajax
			Route::get('/edit', 'SizeController@edit')->name('edit');
			Route::get('/update', 'SizeController@update')->name('update');
			Route::get('/delete_view', 'SizeController@client_delete')->name('delete_view');
	});
	// For unit 
	Route::prefix('unit')->name('unit.')->group(function(){
			Route::get('/view', 'UnitController@index')->name('view');
			Route::post('/store', 'UnitController@store')->name('store');
			Route::get('/delete_client', 'UnitController@destroy')->name('delete');
			// Edit with ajax
			Route::get('/edit', 'UnitController@edit')->name('edit');
			Route::get('/update', 'UnitController@update_client')->name('update');
			Route::get('/delete_view', 'UnitController@client_delete')->name('delete_view');
	});
	// For Product 
	Route::prefix('product')->name('product.')->group(function(){
			Route::get('/view', 'ProductController@index')->name('view');
			Route::post('/store', 'ProductController@store')->name('store');
			Route::get('/delete_client', 'ProductController@destroy')->name('delete');
			// Edit with ajax
			Route::get('/editproduct/{id}', 'ProductController@editproduct')->name('editproduct');
			Route::post('/update', 'ProductController@update')->name('update');
			Route::get('/show/{id}', 'ProductController@show')->name('show');
	});
	Route::prefix('integration')->name('integration.')->group(function(){
			Route::get('/view', 'ProductController@integration')->name('view');
			Route::post('/store', 'ProductController@integration_store')->name('store');
			// Edit with ajax
			Route::get('/edit/{id}', 'ProductController@edit')->name('edit');
			Route::post('/update', 'ProductController@integretion_update')->name('update');
	});

	Route::prefix('supplier_order')->name('supplier_order.')->group(function(){
			Route::get('/view', 'SupplierOrderController@index')->name('view');
			Route::post('/day', 'SupplierOrderController@view')->name('day');
			Route::get('/order_list', 'SupplierOrderController@order_list')->name('order_list');
			Route::get('/pending_order_confirm/{id}', 'SupplierOrderController@pending_order_confirm')->name('pending_order_confirm');
			Route::post('/gross_store_update', 'SupplierOrderController@gross_store_update')->name('gross_store_update');
			// Receive product
			Route::get('/pending_order_receive/{id}', 'SupplierOrderController@pending_order_receive')->name('pending_order_receive');
			Route::post('/product_store', 'SupplierOrderController@product_store')->name('product_store');
			// End
			Route::post('/store', 'SupplierOrderController@gross_store')->name('gross_store');
			// Edit with ajax
			Route::get('/supplierorderedit/{id}', 'SupplierOrderController@supplierorderedit')->name('supplierorderedit');
			Route::post('/update', 'SupplierOrderController@update')->name('update');
	});
	
	// Direct Purchase
	Route::prefix('purchase')->name('purchase.')->group(function(){
			Route::get('/view', 'PurchaseController@index')->name('view');
			Route::post('/store', 'PurchaseController@store')->name('store');
			
	});
	// Inventory Out
	Route::prefix('stock_out')->name('stock_out.')->group(function(){
			Route::get('/view', 'DeliveryController@cleaer_view')->name('cleaer_view');
			Route::post('/store', 'DeliveryController@store')->name('store');
			
	});
	
	Route::prefix('order_delivery')->name('order_delivery.')->group(function(){
			Route::get('/view', 'OrderDeliveryController@index')->name('view');
			
	});
	Route::prefix('return')->name('return.')->group(function(){	
			Route::get('/store/{id}', 'ReturnController@store')->name('store');	
			
			// Edit with ajax
			Route::get('/returnproduct/{id}', 'ReturnController@returnproduct')->name('returnproduct');
	});
	Route::prefix('refund')->name('refund.')->group(function(){
			Route::post('/store', 'RefundController@store')->name('store');	
	});
	
	// Report - Return
	Route::prefix('return_report')->name('return_report.')->group(function(){
			Route::get('/index', 'ReturnController@index')->name('index');
			Route::post('/view', 'ReturnController@view')->name('view');	
	});
	// Invoice
	Route::prefix('invoice')->name('invoice.')->group(function(){
			Route::get('/view', 'InvoiceController@view')->name('view');
			Route::post('/generate', 'InvoiceController@add')->name('add');
			Route::get('/view_m/{id}', 'InvoiceController@individual_view')->name('individual_view');
			Route::post('/view-all', 'InvoiceController@view_invoice_all')->name('view_invoice_all');
	});
	Route::prefix('delivery')->name('delivery.')->group(function(){
			Route::post('/store', 'InvoiceController@store')->name('store');
	});
		// Routine Work
	Route::prefix('routine_work')->name('routine_work.')->group(function(){
			Route::get('/view', 'RoutineworkController@view')->name('view');
			Route::post('/routine-update', 'RoutineworkController@routine_update')->name('update');
			
			// Edit with ajax
			Route::get('/editworkroutine/{id}', 'RoutineworkController@editworkroutine')->name('edit');
	});

	// Report - Inventory
	Route::prefix('inventory_report')->name('inventory_report.')->group(function(){
			//stock
			Route::get('/view', 'ReportController@stock_view')->name('view');
			Route::post('/stock', 'ReportController@stock')->name('stock');
			
			//PDF
			Route::post('/stock-pdf', 'ReportController@stock_pdf')->name('stock.pdf');
			
	});
	
	Route::prefix('purchase_report')->name('purchase_report.')->group(function(){
			//Purchase
			Route::get('/view', 'ReportController@view')->name('view');
			Route::post('/purchase', 'ReportController@purchase')->name('purchase');
			//PDF
			Route::post('/purchase-pdf', 'ReportController@purchase_pdf')->name('purchase.pdf');
	});
	//Product Issue
	Route::prefix('issue_report')->name('issue_report.')->group(function(){
			
			Route::get('/view', 'ReportController@issue_view')->name('view');
			Route::post('/issue', 'ReportController@issue')->name('issue');
			//PDF
			Route::post('/purchase-pdf', 'ReportController@issue_pdf')->name('pdf');
	});
	//Staff Start
	Route::prefix('staff_report')->name('staff_report.')->group(function(){	
			Route::get('/view', 'ReportController@all_staff')->name('view');
			Route::post('/all_view', 'ReportController@all_view')->name('all_view');
			//PDF
			Route::post('/all-pdf', 'ReportController@all_pdf')->name('all_pdf');
			Route::post('/salary-pdf', 'ReportController@salary_pdf')->name('salary_pdf');
			Route::post('/salary_vouche-pdf', 'ReportController@salary_voucher_pdf')->name('salary_voucher_pdf');
			Route::post('/bonus-pdf', 'ReportController@bonus_pdf')->name('bonus_pdf');
			Route::post('/bonus_vouche-pdf', 'ReportController@bonus_voucher_pdf')->name('bonus_voucher_pdf');
	});
	
});