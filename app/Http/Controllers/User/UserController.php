<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Ac_head;
use App\Models\Courier;
use App\Models\Courier_br;
use App\Models\Advance;
use App\Models\Invoice;
use App\Models\Customer_order;
use App\Models\Customer_order_detail;
use App\Models\Generator_reading;
use App\Models\Dpdc_reading;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use PDF;
use DateTime;

class UserController extends Controller
{
    public function index(Request $request)
    {
		$data['previous'] = Dpdc_reading::orderBy('id', 'desc')->first();
		$data['gprevious'] = Generator_reading::orderBy('id', 'desc')->first();

		return view('frontend.pages.customer_order',$data);
    }
	public function index1(Request $request)
    {
		$data['dpdc'] = Dpdc_reading::OrderBy('id','desc')->first();
		$data['dpdc_previous'] = Dpdc_reading::OrderBy('id','desc')->first();
		
		$data['generator'] = Generator_reading::OrderBy('id','desc')->first();
		$data['generator_previous'] = Generator_reading::OrderBy('id','desc')->first();

		return view('frontend.pages.monthly_reading.view1',$data);
    }
	
	public function store(Request $request)
    {		
		$previous = Dpdc_reading::orderBy('id', 'desc')->first();
		$gprevious = Generator_reading::orderBy('id', 'desc')->first();
		
		$date = date("Y-m-t", strtotime($request->date));
		$common_space = $request->G_A + $request->G_B + $request->G_C1 + $request->G_C2 +
						$request->L1_A + $request->L1_B + $request->L1_C1 + $request->L1_C2 +
						$request->L2_A + $request->L2_B + $request->L2_C1 + 
						$request->L3_A + $request->L3_B + $request->L3_C +
						$request->L4_A + $request->L4_B + $request->L4_C1 +
						$request->L5_A + $request->L5_B + $request->L5_C1 + $request->L5_C2 +
						$request->L6_A + $request->L6_B + $request->L6_C +
						$request->L7_A + $request->L7_B + $request->L7_C +
						$request->L8_A + $request->L8_B + $request->L8_C1 + $request->L8_C2 +
						$request->Lounge + $request->Swimming_pool -
						$previous->G_A - $previous->G_B - $previous->G_C1 - $previous->G_C2 -
						$previous->L1_A - $previous->L1_B - $previous->L1_C1 - $previous->L1_C2 -
						$previous->L2_A - $previous->L2_B - $previous->L2_C1 - 
						$previous->L3_A - $previous->L3_B - $previous->L3_C -
						$previous->L4_A - $previous->L4_B - $previous->L4_C1 -
						$previous->L5_A - $previous->L5_B - $previous->L5_C1 - $previous->L5_C2 -
						$previous->L6_A - $previous->L6_B - $previous->L6_C -
						$previous->L7_A - $previous->L7_B - $previous->L7_C -
						$previous->L8_A - $previous->L8_B - $previous->L8_C1 - $previous->L8_C2 -
						$previous->Lounge - $previous->Swimming_pool +
						
						$request->GG_B - $gprevious->G_B +
						$request->GL1_B - $gprevious->L1_B +
						$request->GL1_C1 - $gprevious->L1_C1 +
						$request->GL2_B - $gprevious->L2_B +
						$request->GL6_A - $gprevious->L6_A +
						$request->GL7_A - $gprevious->L7_A 
						;
						
		$data_check = Dpdc_reading::Where ('date', $date)
						->first();
					//dd($data_check);
		if(!is_null($data_check)){
			Toastr::success('Sorry ! Data is already Saved !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	return redirect()->route('electricity.view');
					
		} else {
		$data = new Dpdc_reading;
			$data->date = $date;
			$data->G_A = $request->G_A;
			$data->G_B = $request->G_B;
			$data->G_C1 = $request->G_C1;
			$data->G_C2 = $request->G_C2;
			
			$data->L1_A = $request->L1_A;
			$data->L1_B = $request->L1_B;
			$data->L1_C1 = $request->L1_C1;
			$data->L1_C2 = $request->L1_C2;
			
			$data->L2_A = $request->L2_A;
			$data->L2_B = $request->L2_B;
			$data->L2_C1 = $request->L2_C1;
			
			$data->L3_A = $request->L3_A;
			$data->L3_B = $request->L3_B;
			$data->L3_C = $request->L3_C;
			
			$data->L4_A = $request->L4_A;
			$data->L4_B = $request->L4_B;
			$data->L4_C1 = $request->L4_C1;
			
			$data->L5_A = $request->L5_A;
			$data->L5_B = $request->L5_B;
			$data->L5_C1 = $request->L5_C1;
			$data->L5_C2 = $request->L5_C2;
			
			$data->L6_A = $request->L6_A;
			$data->L6_B = $request->L6_B;
			$data->L6_C = $request->L6_C;
			
			$data->L7_A = $request->L7_A;
			$data->L7_B = $request->L7_B;
			$data->L7_C = $request->L7_C;
			
			$data->L8_A = $request->L8_A;
			$data->L8_B = $request->L8_B;
			$data->L8_C1 = $request->L8_C1;
			$data->L8_C2 = $request->L8_C2;
			
			$data->Lounge = $request->Lounge;
			$data->Swimming_pool = $request->Swimming_pool;
			
			$data->peak = $request->peak;
			$data->offpeak = $request->offpeak;
			$data->total_bill = $request->total_bill;
			if($request->total_bill>0){
			$data->rate = $request->total_bill / ($request->peak + $request->offpeak );
			$data->common_space_bill = $request->total_bill - ($common_space * $request->total_bill / ($request->peak + $request->offpeak ));
			}
			$data->save();
			
			//Generator
			$data = new Generator_reading;
			$data->date = $date;
			$data->G_B = $request->GG_B;
			
			$data->L1_B = $request->GL1_B;
			
			$data->L1_C1 = $request->GL1_C1;
			
			$data->L2_B = $request->GL2_B;
			$data->L4_A = $request->GL4_A;
			$data->L4_B = $request->GL4_B;
			$data->L5_C2 = $request->GL5_C2;
			
			$data->L6_A = $request->GL6_A;
			
			$data->L7_A = $request->GL7_A;
					
			$data->save();
					
			Toastr::success('Data saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	return redirect()->route('electricity.view');
			}
    }
	
	public function edit(Request $request)
    {
		$f = $request->date;
		$data['dpdc'] = Dpdc_reading::where('date', $f)->first();
		$data['dpdc_previous'] = Dpdc_reading::where('date','<', $f)->OrderBy('id','desc')->first();
		
		$data['generator'] = Generator_reading::where('date', $f)->first();
		$data['generator_previous'] = Generator_reading::where('date','<', $f)->OrderBy('id','desc')->first();

		return view('frontend.pages.monthly_reading.view',$data);
    }
	public function update(Request $request)
    {
		 $data = Dpdc_reading::find($request->dpdc_id);
			$data->G_A = $request->G_A;
			$data->G_B = $request->G_B;
			$data->G_C1 = $request->G_C1;
			$data->G_C2 = $request->G_C2;
			
			$data->L1_A = $request->L1_A;
			$data->L1_B = $request->L1_B;
			$data->L1_C1 = $request->L1_C1;
			$data->L1_C2 = $request->L1_C2;
			
			$data->L2_A = $request->L2_A;
			$data->L2_B = $request->L2_B;
			$data->L2_C1 = $request->L2_C1;
			
			$data->L3_A = $request->L3_A;
			$data->L3_B = $request->L3_B;
			$data->L3_C = $request->L3_C;
			
			$data->L4_A = $request->L4_A;
			$data->L4_B = $request->L4_B;
			$data->L4_C1 = $request->L4_C1;
			
			$data->L5_A = $request->L5_A;
			$data->L5_B = $request->L5_B;
			$data->L5_C1 = $request->L5_C1;
			$data->L5_C2 = $request->L5_C2;
			
			$data->L6_A = $request->L6_A;
			$data->L6_B = $request->L6_B;
			$data->L6_C = $request->L6_C;
			
			$data->L7_A = $request->L7_A;
			$data->L7_B = $request->L7_B;
			$data->L7_C = $request->L7_C;
			
			$data->L8_A = $request->L8_A;
			$data->L8_B = $request->L8_B;
			$data->L8_C1 = $request->L8_C1;
			$data->L8_C2 = $request->L8_C2;
			
			$data->Lounge = $request->Lounge;
			$data->Swimming_pool = $request->Swimming_pool;
			
			$data->peak = $request->peak;
			$data->offpeak = $request->offpeak;
			$data->total_bill = $request->total_bill;
			if($request->total_bill>0){
			$data->rate = $request->total_bill / ($request->peak + $request->offpeak );
			$data->common_space_bill = $request->total_bill - $request->total_occupant_bill;
			}
			$data->save();
			
		//Generator
		$data = Generator_reading::find($request->generator_id);
			$data->G_B = $request->GG_B;
			$data->L1_B = $request->GL1_B;
			$data->L1_C1 = $request->GL1_C1;
			$data->L2_B = $request->GL2_B;
			$data->L4_A = $request->GL4_A;
			$data->L4_B = $request->GL4_B;
			$data->L5_C2 = $request->GL5_C2;
			$data->L6_A = $request->GL6_A;
			$data->L7_A = $request->GL7_A;	
			$data->save();
					
			Toastr::success('Data saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	return redirect()->route('electricity.view');
	}
	public function bills(Request $request)
    {
		$f = $request->date;
		$data['dpdc'] = Dpdc_reading::where('date', $f)->first();
		$data['dpdc_previous'] = Dpdc_reading::where('date','<', $f)->OrderBy('id','desc')->first();
		
		$data['generator'] = Generator_reading::where('date', $f)->first();
		$data['generator_previous'] = Generator_reading::where('date','<', $f)->OrderBy('id','desc')->first();
		
		$pdf = PDF::loadView('frontend.pages.pdf.bills.bills_pdf',$data);
		return $pdf->stream('Bills.pdf');
	}
	public function reading(Request $request)
    {
		$f_date = $request->date;
		$date = new DateTime($f_date);
		$date->modify("last day of previous month");
		$f = $date->format("Y-m-d");
		
		$data['dpdc'] = Dpdc_reading::where('date', $f)->first();
		$data['dpdc_previous'] = Dpdc_reading::where('date','<', $f)->OrderBy('id','desc')->first();
		
		$data['generator'] = Generator_reading::where('date', $f)->first();
		$data['generator_previous'] = Generator_reading::where('date','<', $f)->OrderBy('id','desc')->first();
		
		$pdf = PDF::loadView('frontend.pages.pdf.reading.reading',$data);
		return $pdf->stream('Bills.pdf');
	}
	
	public function lttr(Request $request)
    {
		$f = $request->date;
		$data['dpdc'] = Dpdc_reading::where('date', $f)->first();
		$data['dpdc_previous'] = Dpdc_reading::where('date','<', $f)->OrderBy('id','desc')->first();
		
		$data['generator'] = Generator_reading::where('date', $f)->first();
		$data['generator_previous'] = Generator_reading::where('date','<', $f)->OrderBy('id','desc')->first();
		
		$data['generator'] = Generator_reading::where('date', $f)->first();
		
		//return view('frontend.pages.pdf.lttr_pdf',$data);
		
		$pdf = PDF::loadView('frontend.pages.pdf.lttr_pdf',$data);
		return $pdf->stream('Letter.pdf');
	}
	
	public function metter(Request $request)
    {
		$f = $request->date;
		$data['dpdc'] = Dpdc_reading::where('date', $f)->first();
		$data['dpdc_previous'] = Dpdc_reading::where('date','<', $f)->OrderBy('id','desc')->first();
		
		$data['generator'] = Generator_reading::where('date', $f)->first();
		$data['generator_previous'] = Generator_reading::where('date','<', $f)->OrderBy('id','desc')->first();
		
		return view('frontend.pages.metter_reading.reading',$data);
	}
	
	
}
