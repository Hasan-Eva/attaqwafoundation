<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Supplier;
use App\Models\Supplier_order;
use App\Models\Supplier_order_detail;
use App\Models\Customer_order_detail;
use App\Models\Returned_product;
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

class ReturnController extends Controller
{
   public function returnproduct(Request $request)
    {
		$id = $request->id;
		$data['order_details'] = Customer_order_detail::where('id',$id)->first();
		
		return view('frontend.pages.return',$data);
	}
   public function store($id)
    {
       $order = Customer_order_detail::where('id',$id)->first();
	   $return = new Returned_product();
					$return->returned_date = date('Y-m-d');
					$return->customer_order_detail_id = $id;
					$return->stock_id = $order->stock_id;
					$return->quantity = $order->order_quantity;
					$return->save();
			$return_id=$return->id;
					
	   $data = Customer_order_detail::find($id);
			$data->product_status_id = '6';
			$data->returned_product_id = $return_id;
			$data->save();
		
		$trade = Trade::where('stock_id',$order->stock_id)->where('stock_in_hand','!=','0')->orderBy('id','desc')->first();
		$stock = Stock::where('id',$order->stock_id)->first();
		$trade = new Trade();
					$trade->date = date('Y-m-d');
					$trade->order_id = $order->id;
					$trade->stock_id = $order->stock_id;
					$trade->type = 'Return';
					$trade->quantity = $order->order_quantity;
					$trade->amount = 0;
					$trade->stock_in_hand = $stock->balance - $order->order_quantity;
					$trade->invest = $stock->cost_of_fund + ($order->order_quantity);
					$trade->save();
					
		$data = Stock::find($order->stock_id);
					$data->balance = $stock->balance - $order->order_quantity;
					$data->cost_of_fund = $stock->cost_of_fund + ($order->order_quantity);
					$data->save();
					
		Toastr::success('Returned successfuly !!', '', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
    }
	
	public function index()
    {
		return view('backend.pages.report.return.view');
    }
	public function view(Request $request)
    {
			//$sql = "SELECT p.*, s.*, c.*, z.*, r.*, cu.* FROM products p, stocks s, colors c, sizes z, returned_products r, customers cu WHERE r.stock_id=s.id AND s.product_id=p.id AND s.color_id=c.id AND s.size_id=z.id order by r.id DESC ";
			//$data['order']=DB::select($sql);
		$data['from']=$request->from;
		$data['to']=$request->to;
		$data['order'] = Returned_product::whereBetween('returned_date', [$request->from, $request->to])->get();
		return view('backend.pages.report.return.view', $data);
    }
}
