<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Journal;
use App\Models\Location;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Shift;
use App\Models\Staff;
use App\Models\Staff_file;
use App\Models\Guard;
use App\Models\Guard_file;
use App\Models\Cleaner;
use App\Models\Cleaner_file;
use App\Models\Advance_staff;
use App\Models\Advance_cleaner;
use App\Models\Advance_guard;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Image;

class AdvanceController extends Controller
{
   public function staff_view(Request $request)
    {
		 $t=date('Y-m-d');
		$f=date('Y-m-d', strtotime("-2 month"));
		 if ($request->ajax()) {
		 	
			$sql = "SELECT s.*, a.* FROM staff s, advance_staffs a WHERE s.id=a.emp_id AND a.date BETWEEN '".$f."' AND '".$t."' AND balance>0 order by s.id ASC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('joining_date', function($row){
				  return date('d F, Y', strtotime($row->joining_date));
				})
				->addColumn('date', function ($row) { 
            		return date('d F, Y', strtotime($row->date));
        		})
				->addColumn('balance', function ($row) { 
            		return number_format($row->balance,0);
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

		return view('backend.pages.advance.staff.view');
    }
	
	public function staff_store(Request $request)
    {
		$data_check = Advance_staff::Where ('balance', '>', '0')->where('emp_id',$request->emp_id)->first();
		$name = Staff::where('id',$request->emp_id)->first()->name;
					//dd($data_check);
		if(!is_null($data_check)){
			Toastr::success('Sorry ! Data is already Exist !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	 return redirect()->back();
					
		} else {	
			$order = new Advance_staff();
				$order->date = $request->f_date;
				$order->emp_id = $request->emp_id;
				$order->amount = $request->amount;
				$order->received = 0;
				$order->balance = $request->amount;
				$order->save();
				
			$journal = new Journal();
				$journal->j_date = $request->f_date;
				$journal->dr_head = 15;
				$journal->amount = $request->amount;
				$journal->cr_head = 3;
				$journal->transactionwith = $name;
				$journal->particulars = 'Paid the amount to '.$name.' as advance Salary.';
				$journal->save();
		
		Toastr::success('Advance saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->back();
		}
    }
	// For Cleaner	
    public function cleaner_view(Request $request)
    {
		 $t=date('Y-m-d');
		$f=date('Y-m-d', strtotime("-2 month"));
		 if ($request->ajax()) {
		 	
			$sql = "SELECT s.*, a.* FROM cleaners s, advance_cleaners a WHERE s.id=a.emp_id AND a.date BETWEEN '".$f."' AND '".$t."' AND balance>0 order by s.id ASC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('joining_date', function($row){
				  return date('d F, Y', strtotime($row->joining_date));
				})
				->addColumn('date', function ($row) { 
            		return date('d F, Y', strtotime($row->date));
        		})
				->addColumn('balance', function ($row) { 
            		return number_format($row->balance,0);
        		})
				->addColumn('balance', function ($row) { 
            		return number_format($row->balance,0);
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

		return view('backend.pages.advance.cleaner.view');
    }
	
	public function cleaner_store(Request $request)
    {
		$data_check = Advance_cleaner::Where ('balance', '>', '0')->where('emp_id',$request->emp_id)->first();
		$name = Cleaner::where('id',$request->emp_id)->first()->name;
					//dd($data_check);
		if(!is_null($data_check)){
			Toastr::success('Sorry ! Data is already Exist !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	 return redirect()->back();
					
		} else {	
			$order = new Advance_cleaner();
				$order->date = $request->f_date;
				$order->emp_id = $request->emp_id;
				$order->amount = $request->amount;
				$order->received = 0;
				$order->balance = $request->amount;
				$order->save();
			
			$journal = new Journal();
				$journal->j_date = $request->f_date;
				$journal->dr_head = 18;
				$journal->amount = $request->amount;
				$journal->cr_head = 3;
				$journal->transactionwith = $name;
				$journal->particulars = 'Paid the amount to '.$name.' as advance Salary.';
				$journal->save();
		
		Toastr::success('Advance saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->back();
		}
    }
	// For Guard	
	public function guard_view(Request $request)
    {
		 $t=date('Y-m-d');
		$f=date('Y-m-d', strtotime("-2 month"));
		 if ($request->ajax()) {
		 	
			$sql = "SELECT s.*, a.* FROM guards s, advance_guards a WHERE s.id=a.emp_id AND a.date BETWEEN '".$f."' AND '".$t."' AND balance>0 order by s.id ASC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('joining_date', function($row){
				  return date('d F, Y', strtotime($row->joining_date));
				})
				->addColumn('date', function ($row) { 
            		return date('d F, Y', strtotime($row->date));
        		})
				->addColumn('balance', function ($row) { 
            		return number_format($row->balance,0);
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

		return view('backend.pages.advance.guard.view');
    }
	public function guard_store(Request $request)
    {
		$data_check = Advance_guard::Where ('balance', '>', '0')->where('emp_id',$request->emp_id)->first();
		$name = Guard::where('id',$request->emp_id)->first()->name;
					//dd($data_check);
		if(!is_null($data_check)){
			Toastr::success('Sorry ! Data is already Exist !!', 'Title', ["positionClass" => "toast-top-right"]);
		   	 return redirect()->back();
					
		} else {	
			$order = new Advance_guard();
				$order->date = $request->f_date;
				$order->emp_id = $request->emp_id;
				$order->amount = $request->amount;
				$order->received = 0;
				$order->balance = $request->amount;
				$order->save();
				
			$journal = new Journal();
				$journal->j_date = $request->f_date;
				$journal->dr_head = 16;
				$journal->amount = $request->amount;
				$journal->cr_head = 3;
				$journal->transactionwith = $name;
				$journal->particulars = 'Paid the amount to '.$name.' as advance Salary.';
				$journal->save();
		
		Toastr::success('Advance saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->back();
		}
    }
	
}
