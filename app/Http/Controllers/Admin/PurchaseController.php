<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Customer_order;
use App\Models\Customer_order_detail;
use App\Models\Supplier_order;
use App\Models\Supplier;
use App\Models\Ac_head;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Trade;
use App\Models\Invoice;
use App\Models\Journal;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use PDF;

class PurchaseController extends Controller
{
    public function index()
    {	
		//$data['suppliers'] = Supplier::get();
		$data['stocks'] = Stock::select('product_id')->groupBy('product_id')->get();
		//$data['stocks'] = Stock::with(['color'])->select('product_id')->select('color_id')->groupBy('color_id')->get();
		$data['product'] = Product::get();
		$data['pay_types'] = Ac_head::whereIn('id',['3','4','5','6','7'])->get();
				
		return view('backend.pages.direct_purchase.view',$data);
    }
	public function store(Request $request)
    {
		if($request->product_id == null){
			Toastr::success('Sorry!! No Product for purchase !!', 'Title', ["positionClass" => "toast-top-right"]);
			return back();
		}
		else 
		{		
		/*
		$order = new Supplier_order();
			$date = $request->invoice_date;
			$order->date = $request->invoice_date;
			$order->supplier_id = $request->supplier_id;
			$order->order_no = $request->purchase_no;
			$order->total_amount = $request->estimated_amount_1;
			$order->pay_type = $request->pay_type;
			$order->auth_id = Auth::id();
			$order->status = '0';
			$order->save();
		*/	
		/*	
		$order = new Journal();
				$order->j_date = $request->invoice_date;
				$order->dr_head = '24';
				$order->amount = $request->estimated_amount;
				$order->cr_head = $request->pay_type;
				$order->particulars = 'Full Payment for Direct Purchase';
				$order->save();
			$journal_id=$order->id;
		*/		
		$count_product = count($request->product_id);
			for($i=0; $i<$count_product; $i++){
					$stock = Stock::Where ('product_id', $request->product_id[$i])
						->Where ('brand_id', $request->brand_id[$i])
						->Where ('color_id', $request->color_id[$i])
						->Where ('size_id', $request->size_id[$i])->first();
					
					$data = Stock::find($stock->id);
					$qty = $data->balance + $request->buying_qty[$i];
					$cost = $data->cost_of_fund + $request->buying_price[$i];	
					
					$data = Stock::find($stock->id);
					$data->balance = $qty;
					$data->cost_of_fund = $cost;
					$data->save();
		
					$data = new Trade;
					$data->date = $request->invoice_date;
					$data->journal_id = 0; // $journal_id;
					$data->stock_id = $stock->id;
					$data->type = "Purchase";
					$data->quantity = $request->buying_qty[$i];
					$data->amount = $request->buying_price[$i];	
					$data->stock_in_hand = $qty;	
					$data->invest = $cost;	
					$data->save();
					
					$data = Product::find($request->product_id[$i]);
					$data->purchase_price = $request->unit_price[$i];
					$data->save();
					}
					
		Toastr::success('Purchas saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->route('purchase.view');
		}
    }
}
