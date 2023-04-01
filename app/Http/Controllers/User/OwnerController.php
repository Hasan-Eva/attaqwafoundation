<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Ac_head;
use App\Models\Owner;
use App\Models\Journal;
use App\Models\Dpdc_reading;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use PDF;
use DateTime;

class OwnerController extends Controller
{
    public function view(Request $request)
    {
		$first_date = date('Y-m-01', strtotime($request->date));
		$data['fss']=$first_date;
		
		$data['owners'] = Owner::get();
		$data['date'] = $request->date;
		$data['print_date'] = $request->print_date;
		$data['expenses'] = Journal::whereNotIn('dr_head',[3])->whereBetween('j_date', [$first_date, $request->date])->get();
		$data['expense'] = Journal::whereNotIn('dr_head',[3,33])->whereBetween('j_date', [$first_date, $request->date])->get();
		//dd('ADDADA');
		$pdf = PDF::loadView('frontend.pages.pdf.owner.service_pdf',$data); 
		return $pdf->stream('Service.pdf');
	}
}
