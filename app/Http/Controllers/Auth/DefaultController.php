<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Customer_order;
use App\Models\Customer_order_detail;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Unit;
use DB;

class DefaultController extends Controller
{
    public function get_subcategory(Request $request){
		$id = $request->category_id;
		$all = Subcategory::where('category_id',$id)->get();
		//$all = Stock::with(['color'])->select('color_id')->where('product_id',$product_id)->groupBy('color_id')->get();
		return response()->json($all);
	}
	public function get_brand(Request $request){
		$id = $request->product_id;
		$all = Stock::with(['brand'])->select('brand_id')->where('product_id',$id)->groupBy('brand_id')->get();
		return response()->json($all);
	}
	public function get_color(Request $request){
		$id = $request->product_id;
		$brand_id = $request->brand_id;
		$all = Stock::with(['color'])->select('color_id')->where('product_id',$id)->where('brand_id',$brand_id)->groupBy('color_id')->orderByDesc('color_id')->get();
		return response()->json($all);
	}
	public function get_size(Request $request){
		$id = $request->product_id;
		$color_id = $request->color_id;
		$all = Stock::with(['size'])->select('size_id')->where('product_id',$id)->where('color_id',$color_id)->groupBy('size_id')->orderByDesc('size_id')->get();
		return response()->json($all);
	}
	public function get_rate(Request $request){
		$id = $request->product_id;
		$all = Product::where('id',$id)->first()->purchase_price;
		//$all = DB::table('products')->where('id', $product_id)->first()->offer_price;
		return response()->json($all);
	}
	public function get_stock(Request $request){
		$id = $request->product_id;
		//$all = Stock::where('product_id',$product_id)->SUM('balance');
		$all = DB::table('stocks')->where('product_id', $id)->sum('balance');
		return response()->json($all);
	}
	public function get_stock_color(Request $request){
		$product_id = $request->product_id;
		$color_id = $request->color_id;
		$all = DB::table('stocks')->where('product_id', $product_id)->where('color_id', $color_id)->sum('balance');
		return response()->json($all);
	}
	public function get_unit_name(Request $request){
		$id = $request->product_id;
		$unit_id = Product::where('id',$id)->first()->unit_id;
		//$all = Product::with(['unit'])->select('unit_id')->where('product_id',$id)->groupBy('unit_id')->orderByDesc('unit_id')->first();
		$all = Unit::where('id',$unit_id)->first()->unit_name;
		return response()->json($all);
	}
	public function get_stock_size(Request $request){
		$product_id = $request->product_id;
		$color_id = $request->color_id;
		$size_id = $request->size_id;
		//dd($product_id);
		//$all = Stock::where('product_id',$product_id)->SUM('balance');
		$all = DB::table('stocks')->where('product_id', $product_id)->where('color_id', $color_id)->where('size_id', $size_id)->sum('balance');
		return response()->json($all);
	}
	public function get_order(Request $request){
		$id = $request->customer_id;
		$sql = "SELECT * FROM customer_orders WHERE customer_id='".$id."' ";
		$all=DB::select($sql);
		
		return response()->json($all);
	}
	public function get_product(Request $request){
		$id = $request->order_id;
		$sql = "SELECT s.*, p.*, c.*, z.*, d.* FROM customer_order_details d, stocks s, products p, colors c, sizes z WHERE d.stock_id=s.id AND s.product_id=p.id AND s.color_id=c.id AND s.size_id=z.id AND d.customer_order_id='".$id."' AND d.confirm_status_id<=2 AND d.product_status_id!=5 ";
		$all=DB::select($sql);
		
		return response()->json($all);
	}
	public function get_courier_charge(Request $request){
		$id = $request->order_id;
		$all = Customer_order::where('id',$id)->first()->courier_charge;
		return response()->json($all);
	}
	public function get_advance_avail(Request $request){
		$id = $request->order_id;
		$order = Customer_order::where('id',$id)->first();
		$all = $order->total_advance - $order->total_advance_availed;
		return response()->json($all);
	}
	public function get_unit_stock(Request $request){
		$id = $request->order_details_id;
		$stock_id = Customer_order_detail::where('id',$id)->first()->stock_id;
		$all = Stock::where('id',$stock_id)->first()->balance;
		return response()->json($all);
	}
	public function get_order_qantity(Request $request){
		$id = $request->order_details_id;
		$all = Customer_order_detail::where('id',$id)->first()->order_quantity;
		return response()->json($all);
	}
	public function get_unit_price(Request $request){
		$id = $request->order_details_id;
		$order = Customer_order_detail::where('id',$id)->first();
		$all = $order->product_price / $order->order_quantity;
		return response()->json($all);
	}
	public function get_total_price(Request $request){
		$id = $request->order_details_id;
		$all = Customer_order_detail::where('id',$id)->first()->product_price;
		return response()->json($all);
	}
	public function get_cleaner(Request $request){
		$id = $request->location_id;
		 $f=date('Y-m-d');
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, cleaner_files f, cleaners s, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$f."' group by cleaner_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.cleaner_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.location_id='".$id."' AND f.type!='Released' order by s.id ASC ";
		
		$all=DB::select($sql);
		
		return response()->json($all);
	}
	 
}
