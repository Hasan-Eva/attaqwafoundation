<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Supplier_order;
use App\Models\Supplier_order_detail;
use App\Models\Customer_order;
use App\Models\Customer_order_detail;
use App\Models\Trade;
use App\Models\Ac_head;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Color;
use App\Models\Size;
use App\Models\Gender;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;

class OrderDeliveryController extends Controller
{
   public function index()
    {
		$data['couriers'] = Customer_order::get();
		//$data['customers'] = Customer::get();
		$data['order_detail'] = Customer_order_detail::where('product_status_id','<=','4')->distinct('customer_order_id')->get();
		//$sql = "SELECT * FROM customers WHERE id=(SELECT customer_id  FROM customer_orders WHERE confirm_status_id=2 AND delivery_status_id<=2) order by id ASC ";
		//$data['customers']=DB::select($sql);
		
		$data['customers'] = Customer_order::with(['customer'])->select('customer_id')->where('confirm_status_id','2')->where('delivery_status_id','<=','2')->groupBy('customer_id')->get();
		
		return view('backend.pages.order_delivery.view',$data);
    }
}
