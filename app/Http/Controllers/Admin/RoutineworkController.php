<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Journal;
use App\Models\Routine_work;
use Toastr;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use PDF;

class RoutineworkController extends Controller
{
    public function view()
	{
		$data['routine_works'] = Routine_work::get();
		return view('backend.pages.routine_work.view',$data);
	}
	public function editworkroutine(Request $request)
    {
		$id = $request->id;
		
		$data['staffs'] = Routine_work::where('id',$id)->first();
		
		return view('backend.pages.routine_work.edit',$data);
    }
	public function routine_update(Request $request)
    {
        $data = Routine_work::find($request->id);
		$data->monthly_service_date  = $request->monthly_service_date;
		$data->quarterly_service_date  = $request->quarterly_service_date;
		$data->halfyearly_service_date  = $request->halfyearly_service_date;
		$data->yearly_service_date  = $request->yearly_service_date;
		$data->save();
		
		Toastr::success( 'Updated successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
    }
}
