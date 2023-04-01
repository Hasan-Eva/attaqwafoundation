<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Staff;
use App\Models\Staff_file;
use App\Models\Guard;
use App\Models\Guard_file;
use App\Models\Cleaner;
use App\Models\Cleaner_file;
use App\Models\Absent_staff;
use App\Models\Absent_cleaner;
use App\Models\Absent_guard;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Image;

class AbsentController extends Controller
{
   public function staff_view(Request $request)
    {
		 $t=date('Y-m-d');
		$f=date('Y-m-d', strtotime("-2 month"));
		 if ($request->ajax()) {
		 	
			$sql = "SELECT s.*, a.* FROM staff s, absent_staffs a WHERE s.id=a.emp_id AND a.date BETWEEN '".$f."' AND '".$t."' AND total_absent>0 order by a.date DESC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('date', function($row){
                	return date("F, Y", strtotime($row->date)); 
           		 })
				->addColumn('image', function ($data) { 
            		$url= asset('public/images/staff/'.$data->image);
            		return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
        		})
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					';
                    return $actionBtn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        	}

		return view('backend.pages.absent.staff.view');
    }
	
	public function staff_store(Request $request)
    {
		$first_date = date('Y-m-01', strtotime($request->f_date));
		$last_date = date('Y-m-t', strtotime($request->f_date));
		$data_check = Absent_staff::where('emp_id',$request->emp_id)->whereBetween ('date', [$first_date, $last_date])->first();
					//dd($data_check);
		if(!is_null($data_check)){
			Toastr::success('Sorry ! Data is already Exist !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	 return redirect()->back();
					
		} else {	
			$order = new Absent_staff();
				$order->date = $request->f_date;
				$order->emp_id = $request->emp_id;
				$order->total_absent = $request->total_absent;
				$order->save();
		
		Toastr::success('Absent saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->back();
		}
    }
	// For Cleaner	
    public function cleaner_view(Request $request)
    {
		 $t=date('Y-m-d');
		$f=date('Y-m-d', strtotime("-2 month"));
		 if ($request->ajax()) {
		 	
			$sql = "SELECT s.*, a.* FROM cleaners s, absent_cleaners a WHERE s.id=a.emp_id AND a.date BETWEEN '".$f."' AND '".$t."' AND total_absent>0 order by a.date DESC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('date', function($row){
                	return date("F, Y", strtotime($row->date)); 
           		 })
				->addColumn('image', function ($data) { 
            		$url= asset('public/images/cleaner/'.$data->image);
            		return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
        		})
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					';
                    return $actionBtn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        	}

		return view('backend.pages.absent.cleaner.view');
    }
	
	public function cleaner_store(Request $request)
    {
		$first_date = date('Y-m-01', strtotime($request->f_date));
		$last_date = date('Y-m-t', strtotime($request->f_date));
		$data_check = Absent_cleaner::where('emp_id',$request->emp_id)->whereBetween ('date', [$first_date, $last_date])->first();
					//dd($data_check);
		if(!is_null($data_check)){
			Toastr::success('Sorry ! Data is already Exist !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	 return redirect()->back();
					
		} else {	
			$order = new Absent_cleaner();
				$order->date = $request->f_date;
				$order->emp_id = $request->emp_id;
				$order->total_absent = $request->total_absent;
				$order->save();
		
		Toastr::success('Absent saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->back();
		}
    }
	// For Guard	
	public function guard_view(Request $request)
    {
		 $t=date('Y-m-d');
		$f=date('Y-m-d', strtotime("-2 month"));
		 if ($request->ajax()) {
		 	
			$sql = "SELECT s.*, a.* FROM guards s, absent_guards a WHERE s.id=a.emp_id AND a.date BETWEEN '".$f."' AND '".$t."' AND total_absent>0 order by a.date DESC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('date', function($row){
                	return date("F, Y", strtotime($row->date)); 
           		 })
				->addColumn('image', function ($data) { 
            		$url= asset('public/images/guard/'.$data->image);
            		return '<img src='.$url.' border="0" width="40" class="img-rounded" align="center" />';
        		})
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					';
                    return $actionBtn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        	}

		return view('backend.pages.absent.guard.view');
    }
	public function guard_store(Request $request)
    {
		$first_date = date('Y-m-01', strtotime($request->f_date));
		$last_date = date('Y-m-t', strtotime($request->f_date));
		$data_check = Absent_guard::where('emp_id',$request->emp_id)->whereBetween ('date', [$first_date, $last_date])->first();
					//dd($data_check);
		if(!is_null($data_check)){
			Toastr::success('Sorry ! Data is already Exist !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	 return redirect()->back();
					
		} else {	
			$order = new Absent_guard();
				$order->date = $request->f_date;
				$order->emp_id = $request->emp_id;
				$order->total_absent = $request->total_absent;
				$order->save();
		
		Toastr::success('Absent saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->back();
		}
    }
}
