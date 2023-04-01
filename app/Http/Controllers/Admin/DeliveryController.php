<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Customer_order;
use App\Models\Customer_order_detail;
use App\Models\Supplier_order;
use App\Models\Location;
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

class DeliveryController extends Controller
{
    public function cleaer_view()
    {	
		$data['locations'] = Location::get();
		$data['stocks'] = Stock::select('product_id')->groupBy('product_id')->get();
		$data['product'] = Product::get();
		 
		return view('backend.pages.stock_out.view',$data);
    }
	public function store(Request $request)
    {
		if($request->product_id == null){
			Toastr::success('Sorry!! No Product for purchase !!', 'Title', ["positionClass" => "toast-top-right"]);
			return back();
		}
		else 
		{		
			
		$count_product = count($request->product_id);
			for($i=0; $i<$count_product; $i++){
					$stock = Stock::Where ('product_id', $request->product_id[$i])
						->Where ('brand_id', $request->brand_id[$i])
						->Where ('color_id', $request->color_id[$i])
						->Where ('size_id', $request->size_id[$i])->first();
					
					$data = Stock::find($stock->id);
					$qty = $data->balance - $request->buying_qty[$i];
					$cost = $data->cost_of_fund - $request->buying_price[$i];	
					
					$data = Stock::find($stock->id);
					$data->balance = $qty;
					$data->cost_of_fund = $cost;
					$data->save();
		
					$data = new Trade;
					$data->date = $request->invoice_date;
					$data->journal_id = NULL;
					$data->stock_id = $stock->id;
					$data->type = "Issue";
					$data->quantity = $request->buying_qty[$i];
					$data->amount = $request->buying_price[$i];	
					$data->stock_in_hand = $qty;	
					$data->invest = $cost;	
					$data->trade_with = $request->cleaner_id;
					$data->save();
					}
					
		Toastr::success('Stock out successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return back();
		}
    }
}
