<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Supplier;
use App\Models\Supplier_order;
use App\Models\Supplier_order_detail;
use App\Models\Customer_order;
use App\Models\Customer_order_detail;
use App\Models\Advance;
use App\Models\Refund;
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

class RefundController extends Controller
{
    public function store(Request $request)
    {
       $order = Customer_order::where('id',$request->id)->first();
	   	
		$data = new Advance();
			$data->advance_date = $request->refund_date;
			$data->customer_order_id = $order->id;
			$data->advance_from = $request->refund_from;
			$data->ac_head_id = $request->pay_type;
			$data->advance_amount = - $request->refund_amount;
			$data->save();
			
		$data = Customer_order::find($request->id);
			$data->total_advance =$data->total_advance - $request->refund_amount;
			$data->confirm_status_id = '4';
			$data->save();
			
	   Customer_order_detail::where('customer_order_id',$order->id)->update(array(
							 'confirm_status_id'=>'3',
							  'product_status_id'=>'1'
				));
						
		Toastr::success('Refund successfuly !!', '', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
    }
}
