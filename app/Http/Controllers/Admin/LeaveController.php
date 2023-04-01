<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Staff;
use App\Models\Staff_leave;
use App\Models\Leave_type;
use App\Models\Leave_purpose;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Trade;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use PDF;

class LeaveController extends Controller
{
    public function staff_view(Request $request)
	{
		if ($request->ajax()) {
		 	
			$sql = "SELECT a.*, a.name as ename, b.*, t.*, l.* FROM staff a, designations b, leave_types t, staff_leaves l WHERE a.id=l.staff_id AND a.designation_id=b.id  AND l.leave_type_id=t.id order by l.id DESC ";
			$data=DB::select($sql);
			
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('image', function ($data) { 
            		$url= asset('public/images/staff/'.$data->image);
            		return '<img src='.$url.' border="0" width="30" class="img-rounded" align="center" />';
        		})
				->addColumn('f_date', function($row){
				  return date('d-m-Y', strtotime($row->f_date));
				})
				->addColumn('t_date', function($row){
				  return date('d-m-Y', strtotime($row->t_date));
				})
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					<button type="button" class="btn btn-success btn-xs" id="getDeleteData" data-id="'.$data->id.'" data-toggle="modal" data-target="#deleteModal">Delete</button>
					';
                    return $actionBtn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        	}
		$data['types']=Leave_type::get();
		$data['leave_purposes']=Leave_purpose::get();
		return view('backend.pages.leave.staff.view',$data);
	}
	public function staff_store(Request $request)
    {
		$data_check = Staff_leave::Where ('f_date', $request->f_date)->where('staff_id',$request->emp_id)->first();
		
		if(!is_null($data_check)){
			Toastr::success('Sorry ! Data is already Exist !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	 return redirect()->back();
					
		} else {	
			$order = new Staff_leave();
				$order->staff_id = $request->emp_id;
				$order->leave_type_id = $request->leave_type_id;
				$order->f_date = $request->f_date;
				$order->t_date = $request->t_date;
				$order->days = $request->days;
				$order->remarks = $request->remarks;
				$order->leave_purpose_id = $request->leave_purpose_id;
				$order->status = 1;
				$order->save();
				
		Toastr::success('Leave saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->back();
		}
    }
	public function register(Request $request)
    {
		$data['f_date']=$request->f_date;
		$data['t_date']=$request->t_date;
		$data['registers'] = Staff_leave::Where ('f_date', '>=', $request->f_date)->where('t_date', '<=', $request->t_date)->groupBy('staff_id')->get();
		
		$pdf = PDF::loadView('backend.pages.leave.staff.register_pdf',$data);
		return $pdf->stream('register.pdf');
    }
	public function application(Request $request)
    {
		$data['f_date']=$request->f_date;
		$data['t_date']=$request->t_date;
		$data['data'] = Staff::Where ('id', $request->emp_id)->first();
		
		$pdf = PDF::loadView('backend.pages.leave.staff.application_pdf',$data);
		return $pdf->stream('application.pdf');
    }
}
