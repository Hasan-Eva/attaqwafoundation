<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Customer_order;
use App\Models\Customer_order_detail;
use App\Models\Stock;
use App\Models\Trade;
use App\Models\Invoice;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use PDF;

class InvoiceController extends Controller
{
    public function view(Request $request)
    {
		/*
		$data['invoice'] = Invoice::orderBy('id','desc')->limit(150)->get();
		
		return view('backend.pages.invoice.view',$data);
		*/
		if ($request->ajax()) {
		 	
			$sql = "SELECT o.*, c.*, i.* FROM invoices i, customer_orders o, customers c WHERE i.customer_order_id=o.id AND o.customer_id=c.id order by i.id DESC ";
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					<a href="'. route('invoice.individual_view', $data->id) .'" target="_blank" class="btn btn-danger btn-xs confirm" type="submit" style="margin-left:10px;" title="Show Invoice"><i class="fa fa-list"></i></a>
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		return view('backend.pages.invoice.view');
    }
	public function individual_view($id)
    {
		$data['invoice'] = Invoice::where('id',$id)->first();
		$customer_order_detail = Customer_order_detail::where('invoice_id',$id)->first();
		$data['customer_order'] = Customer_order::where('id',$customer_order_detail->customer_order_id)->first();
		$data['customer_order_detail'] = Customer_order_detail::where('invoice_id',$id)->get();
		
		$pdf = PDF::loadView('backend.pages.invoice.individual_view',$data);
		return $pdf->stream('invoice.pdf');
    }
	public function view_invoice_all(Request $request)
    {
		$f=$request->f_date;
		$t=$request->t_date;
		//$data['customer_order'] = Customer_order::whereBetween('delivery_date',[$f,$t])->groupBy('invoice_id')->get();
		
		$sql = "SELECT i.id as i_id, i.invoice_date, i.invoice_amount, i.discount, i.advance_avail, i.courier_charge, d.stock_id, o.customer_id, c.customer_name, c.address_1, c.phone_1, s.product_id, cu.short_name, cubr.courier_br FROM invoices i, customer_order_details d, customer_orders o, customers c, stocks s, couriers cu, courier_brs cubr WHERE d.invoice_id=i.id AND d.customer_order_id=o.id AND o.customer_id=c.id AND i.courier_br_id=cubr.id AND cubr.courier_id=cu.id AND d.stock_id=s.id AND i.invoice_date BETWEEN '".$f."' AND '".$t."' group by i.id, i.invoice_date, i.invoice_amount, i.discount, i.advance_avail, i.courier_charge, d.stock_id, o.customer_id, c.customer_name, c.address_1, c.phone_1, s.product_id, cu.short_name, cubr.courier_br ";
		$data['customer_order']=DB::select($sql);
		
		$pdf = PDF::loadView('backend.pages.invoice.invoice_all',$data);
		return $pdf->stream('invoice_all.pdf',array('Attachment'=>false));
		//return $pdf->setPaper('a4')->stream('invoice_all.pdf');
    }
	public function store(Request $request)
    {	
		if(!isset($request->product_id)) {  // Validation for selecting Order
				Toastr::success($request->category_name. ' Sorry !! No product is selected', 'Title', ["positionClass" => "toast-top-right"]);
				return back();
			}
		$ordercount = count($request->product_id);
		for($i=0; $i<$ordercount; $i++){
			$stock_id[$i] = Customer_order_detail::where('id',$request->product_id[$i])->first()->stock_id;
			$balance[$i] = Stock::where('id',$stock_id[$i])->first()->balance;
			$cost_of_fund[$i] = Stock::where('id',$stock_id[$i])->first()->cost_of_fund;
			if($balance[$i] <=0) {  // will be changed as 0
				Session()->flash('success','Sorry!! No Stock Balance !!');
				Toastr::success($request->category_name. ' Sorry !! Insufficient Stock Balance '. $request->product_name[$i], 'Title', ["positionClass" => "toast-top-right"]);
				return back();
			} 
		}	
	
		$invoice = new Invoice();
			$invoice->invoice_date = $request->invoice_date;
			$invoice->customer_order_id = $request->order_id; //$request->order_id
			$invoice->discount = $request->discount_amount;
			$invoice->advance_avail = $request->advance_avail;
			$invoice->invoice_amount = $request->estimated_amount_1;
			$invoice->courier_br_id = 2 ;
			$invoice->courier_charge = $request->courier_charge;
			$invoice->save();
			$invoice_id = $invoice->id;
			
		
		$data = Customer_order::find($request->order_id);
			$data->total_advance_availed = $data->total_advance_availed + $request->advance_avail;
			$data->courier_charge = $request->courier_charge;
			$data->save();
			
		for($i=0; $i<$ordercount; $i++){
			$data = Customer_order_detail::find($request->product_id[$i]);
			$data->product_status_id = 5 ;
			$data->invoice_id = $invoice_id;
			$data->save();
			} 
		// Stock management
		for($i=0; $i<$ordercount; $i++){
			$stock_id[$i] = Customer_order_detail::where('id',$request->product_id[$i])->first()->stock_id;
			$balance[$i] = Stock::where('id',$stock_id[$i])->first()->balance;
			$cost_of_fund[$i] = Stock::where('id',$stock_id[$i])->first()->cost_of_fund;
			$cost_of_uit[$i] = $cost_of_fund[$i] / $balance[$i];
			
			$data = Stock::find($stock_id[$i]);
					$data->balance = $balance[$i] - $request->order_quantity[$i];
					$data->cost_of_fund = $cost_of_fund[$i] - ($request->order_quantity[$i] * $cost_of_uit[$i]);
					$data->save();
			
			$trade = new Trade();
					$trade->date = $request->invoice_date;
					$trade->order_id = 0;
					$trade->stock_id = $stock_id[$i];
					$trade->type = 'Sell';
					$trade->quantity = $request->order_quantity[$i];
					$trade->amount = $request->order_quantity[$i] * $request->unit_price[$i];
					$trade->stock_in_hand = $balance[$i] - $request->order_quantity[$i];
					$trade->invest = $cost_of_fund[$i] - ($request->order_quantity[$i] * $cost_of_uit[$i]);
					$trade->save();
			}

		Toastr::success($request->category_name. 'Success !! Invoice generated successfuly', 'Title', ["positionClass" => "toast-top-right"]);
		return back();
		
		
	}
}
