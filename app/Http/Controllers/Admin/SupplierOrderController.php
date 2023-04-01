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
use App\Models\Trade;
use App\Models\Ac_head;
use App\Models\Journal;
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

class SupplierOrderController extends Controller
{
    public function index(Request $request)
    {
		$data['categories'] = Category::get();
		return view('backend.pages.supplier_order.view',$data);
    }
	public function view(Request $request)
    {
		$f=$request->from;
		$t=$request->to;
		$data['suppliers'] = Supplier::get();
		$data['pay_types'] = Ac_head::whereIn('id',['3','4','5','6','7'])->get();
		//$data['customer_order'] = Customer_order::where('confirm_status','1')->whereIn('status',['0','8'])->orderBy('id','asc')->get();
		//$data['customer_order'] = Customer_order::where('confirm_status','1')->where('status','0')->orderBy('id','asc')->get();
		$data['categories'] = Category::get();
		
		$sql = "SELECT p.product_name, p.offer_price, p.image, cl.color_name, s.id, si.size_name, sum(d.order_quantity) tquantity FROM products p, customer_orders o, customer_order_details d, stocks s, colors cl, sizes si Where d.customer_order_id=o.id AND d.customer_order_details_date BETWEEN '".$f."' AND '".$t."' AND d.stock_id=s.id AND o.confirm_status_id=2 AND d.confirm_status_id=2 AND d.product_status_id=1 AND p.id=s.product_id AND s.color_id=cl.id AND s.size_id=si.id GROUP BY p.product_name, p.image, cl.color_name, s.id, si.size_name ORDER BY tquantity DESC";
		$data['customer_order'] = DB::select($sql);
		return view('backend.pages.supplier_order.view',$data);
    }
	
	public function gross_store(Request $request)
    {
		$ordercount = count($request->stock_id);
	 
		$order = new Supplier_order();
			$order->date = $request->date;
			$order->supplier_id = $request->supplier_id;
			$order->auth_id = Auth::id();
			$order->status = '1';
			$order->save();
			
			$order_id = $order->id;	
		
		for($i=0; $i<$ordercount; $i++){
			if($request->buying_qty[$i]>0){
				Customer_order_detail::where('stock_id',$request->stock_id[$i])->where('confirm_status_id','2')->where('product_status_id','1')->update(array(
							 'product_status_id'=>'2',
							 'supplier_order_id' => $order_id
				));
			}
		}
		
		for($i=0; $i<$ordercount; $i++){
				if($request->buying_qty[$i] > 0){
				$order_details = Supplier_order_detail::Where ('supplier_order_id', $order_id)
						->Where ('stock_id', $request->stock_id[$i])->first();
					//dd($order_details);
				if(!is_null($order_details)){
					$order_details->quantity = $order_details->quantity + $request->buying_qty[$i];
					
				} else {
					$order_details = new Supplier_order_detail();
					$order_details->supplier_order_id = $order_id;
					$order_details->stock_id = $request->stock_id[$i];
					$order_details->quantity = $request->quantity[$i];
					$order_details->buying_qty = $request->buying_qty[$i];
					$order_details->receive_qty = '0';
					$order_details->unit_price = $request->unit_price[$i];
					$order_details->weight = '0';
					$order_details->shipping_cost = '0';
					$order_details->total_price = '0';
					$order_details->status = '1';
					}
					$order_details->save();
				}
			}
			
		Toastr::success('Product Selected successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->route('supplier_order.view');
	}
	public function order_list()
    {
		$data['suppliers'] = Supplier::get();
		$data['pay_types'] = Ac_head::whereIn('id',['3','4','5','6','7'])->get();
		$data['orders'] = Supplier_order::orderBy('id','desc')->get();
		
		return view('backend.pages.supplier_order.order_list',$data);
    }
	public function pending_order_confirm($id)
    {
		$data['categories'] = Category::get();
		$data['suppliers'] = Supplier::get();
		$data['pay_types'] = Ac_head::whereIn('id',['3','4','5','6','7'])->get();
		$data['order'] = Supplier_order::Where('id',$id)->first();
		$data['order_details'] = Supplier_order_detail::Where('supplier_order_id',$id)->get();
		
        return view('backend.pages.supplier_order.confirm',$data);
    }
	public function supplierorderedit(Request $request)
    {
		$id = $request->id;
		//$order = DB::table('customer_orders')->where('id',$id)->first();
		$data['order'] = Supplier_order_detail::where('id',$id)->first();
		
		 return view('backend.pages.supplier_order.edit',$data);
	}
	public function update(Request $request)
    {
		$id = $request->id;
		if($request->status==1){
			Supplier_order_detail::where('id',$id)->update(array(
				'buying_qty'=>$request->buying_qty,
				'unit_price'=>$request->unit_price,
				'total_price' =>$request->buying_qty * $request->unit_price,
				'status' =>$request->status
				));
			Customer_order_detail::where('stock_id',$request->stock_id)->where('supplier_order_id',$request->supplier_order_id)->update(array(
							 'product_status_id'=>'2'
				));
		}
		if($request->status==0){
			Supplier_order_detail::where('id',$id)->update(array(
				'buying_qty'=>0,
				'unit_price'=>0,
				'total_price' =>0,
				'status' =>$request->status
				));
			Customer_order_detail::where('stock_id',$request->stock_id)->where('supplier_order_id',$request->supplier_order_id)->update(array(
							 'product_status_id'=>'1'
							 //'supplier_order_id' => '0'
				));
		}
			
		return redirect()->back();
	}
	public function gross_store_update(Request $request)
    {
		$id = $request->order_id;
			Supplier_order::where('id',$id)->update(array(
				'date'=>$request->date,
				'supplier_id'=>$request->supplier_id,
				'order_no'=>$request->order_no,
				'advance_amount'=>$request->advance_amount,
				'total_amount'=>$request->total_amount,
				'pay_type' =>$request->pay_type,
				'status' =>2
				));
			$ordercount = count($request->stock_id);
			for($i=0; $i<$ordercount; $i++){
				Customer_order_detail::where('stock_id',$request->stock_id[$i])->where('supplier_order_id',$request->supplier_order_id[$i])->update(array(
								 'product_status_id'=>'3'
								 //'supplier_order_id' => '0'
					));	
			}
		return redirect()->back();
	}
	
	public function pending_order_receive($id)
    {
		$data['pay_types'] = Ac_head::whereIn('id',['3','4','5','6','7'])->get();
		$data['order'] = Supplier_order::Where('id',$id)->first();
		$order = Supplier_order::Where('id',$id)->first();
		$data['suppliers'] = Supplier::Where('id',$order->supplier_id)->first();
		$data['order_details'] = Supplier_order_detail::Where('supplier_order_id',$id)->whereIn('status',['1','2'])->get();
		
        return view('backend.pages.supplier_order.receive',$data);
    }
	public function product_store(Request $request)
    {
		//dd($request->order);
		if($request->current_receive_qty == null){
			Toastr::success('Sorry!! No Product is selected !!', 'Title', ["positionClass" => "toast-top-right"]);
			return redirect()->back();
		}
		else 
		{				
		$ordercount = count($request->id);
			for($i=0; $i<$ordercount; $i++){
				if($request->current_receive_qty[$i] != null){
					$order_details = Supplier_order_detail::find($request->id[$i]);
					$order_details->receive_qty = $request->receive_qty[$i] + $request->current_receive_qty[$i];
					$order_details->weight = $order_details->weight + $request->weight[$i];
					$order_details->shipping_cost = $order_details->shipping_cost + $request->shipping_cost[$i];
					$order_details->total_price = $request->buying_price[$i];	
					$order_details->status = '2';
					$order_details->save();
				}
			}
			for($i=0; $i<$ordercount; $i++){
				Customer_order_detail::where('stock_id',$request->stock_id[$i])->where('supplier_order_id',$request->order_id)->update(array(
								 'product_status_id'=>'4'
								 //'supplier_order_id' => '0'
					));	
			}
				
		$ordercount = count($request->id);
			for($i=0; $i<$ordercount; $i++){
				if($request->current_receive_qty[$i] != null){
					$trade = new Trade();
					$trade->date = $request->date;
					$trade->order_id = $request->order_id;
					$trade->stock_id = $request->stock_id[$i];
					$trade->type = 'Buy';
					$trade->quantity = $request->current_receive_qty[$i];
					$trade->amount = $request->buying_price[$i];	
					$trade->stock_in_hand = $request->balance[$i] + $request->current_receive_qty[$i];
					$trade->invest = $request->cost_of_fund[$i] + $request->buying_price[$i];
					$trade->save();
					}
				}
			for($i=0; $i<$ordercount; $i++){
					$stock = Stock::find($request->stock_id[$i]);
					$stock->balance = $request->balance[$i] + $request->current_receive_qty[$i];
					$stock->cost_of_fund = $request->cost_of_fund[$i] + $request->buying_price[$i];	
					$stock->save();
				}
			Supplier_order::where('id',$request->order_id)->update(array(
                         'status'=>'3'
			));
			
			$order_id = $request->order_id;
			/*
			$order_id = Order_Details::Where('order_id',$order_id)->first()->order_id;
					$order = Order::find($order_id);
					$order->status = '2';
					$order->save();
			//$order_id = $request->order_id;
			for($i=0; $i<$ordercount; $i++){
			Customer_order::where('order_id',$request->order_id[$i])->update(array(
                         'status'=>'2'
			));
			
				$sql = "UPDATE `customer_orders` SET 
						`status`='2'
							WHERE order_id='".$request->order_id[$i]."'"; 
				$data=DB::select($sql);
			
				}
			*/
					
		$order = new Journal();
			$order->j_date = $request->date;
			$order->dr_head = '5';
			$order->amount = $request->due_amount;
			$order->cr_head = $request->pay_type;
			$order->particulars = 'Full Payment for Order no '.$order_id;
			$order->save();
		
		Toastr::success('Product received successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->back();
		}
    }
	
}
