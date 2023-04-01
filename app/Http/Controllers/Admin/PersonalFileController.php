<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Upazila;
use App\Models\Location;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Shift;
use App\Models\Staff;
use App\Models\Staff_file;
use App\Models\Cleaner;
use App\Models\Cleaner_file;
use App\Models\Guard;
use App\Models\Guard_file;
use App\Models\Blood_group;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Image;

class PersonalFileController extends Controller
{
    public function staff_view(Request $request)
    {
		 $f=date('Y-m-d');
		 if ($request->ajax()) {
		 	
			//$sql = "SELECT d.*, f.*, s.* FROM designations d, staff_files f, staff s WHERE f.staff_id=s.id AND s.designation_id=d.id order by s.id ASC ";
			$sql = "SELECT sh.*, l.*, dpt.*, d.*, f.*, s.* FROM shifts sh, locations l, departments dpt, designations d, staff_files f, staff s, (Select staff_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  staff_files  where execution_date<='".$f."' group by staff_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.staff_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.shift_id=sh.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs pfi" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#PFModal">Edit</button> 
					
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		

		$data['upazilas'] = Upazila::get();
		$data['locations'] = Location::orderBy('id', 'DESC')->get();
		$data['designations'] = Designation::whereIn('id',[6,8,11,14,15,16,18,20])->get();
		$data['departments'] = Department::orderBy('id', 'ASC')->get();
		$data['shifts'] = Shift::get();
		return view('backend.pages.employee.staff.pf',$data);
    }
	
	public function pf_staff(Request $request)
    {
		$id = $request->id;
		$f=date('Y-m-d');
		$data['staffs'] = DB::table('staff')->where('id',$id)->first();
		$data['staff_file'] = Staff_file::where('staff_id',$id)->orderBy('id', 'DESC')->first();
		$data['pf'] = Staff_file::where('staff_id',$id)->orderBy('id', 'ASC')->get();
		$data['designations'] = Designation::whereIn('id',[6,8,11,14,15,16,18,20])->get();
		$data['departments'] = Department::orderBy('id', 'ASC')->get();
		$data['locations'] = Location::get();
		$data['shifts'] = Shift::get();
		
		return view('backend.pages.employee.staff.pf_insert',$data);
    }
	public function staff_file_store(Request $request)
    {
		$data = new Staff_file();
			$data->staff_id = $request->id;
			$data->execution_date = $request->execution_date;
			$data->type = $request->type;
			$data->designation_id = $request->designation_id;
			$data->jobtype = $request->jobtype;
			$data->location_id = $request->location_id;
			$data->department_id = $request->department_id;
			$data->basic_salary = $request->total_salary/2;
			$data->total_salary = $request->total_salary;
			$data->shift_id = $request->shift_id;
			$data->save();
			
		Toastr::success($request->name. 'Saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
	
	
	public function cleaner_view(Request $request)
    {
		 $f=date('Y-m-d');
		 if ($request->ajax()) {
		 	
			//$sql = "SELECT d.*, f.*, s.* FROM designations d, staff_files f, staff s WHERE f.staff_id=s.id AND s.designation_id=d.id order by s.id ASC ";
			$sql = "SELECT sh.*, l.*, dpt.*, d.*, f.*, s.* FROM shifts sh, locations l, departments dpt, designations d, cleaner_files f, cleaners s, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$f."' group by cleaner_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.cleaner_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.shift_id=sh.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs pfi" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#PFModal">Edit</button> 
					
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		

		$data['upazilas'] = Upazila::get();
		$data['locations'] = Location::orderBy('id', 'DESC')->get();
		$data['designations'] = Designation::whereIn('id',[6,8,11,14,15,16,18,20])->get();
		$data['departments'] = Department::orderBy('id', 'ASC')->get();
		$data['shifts'] = Shift::get();
		return view('backend.pages.employee.cleaner.pf',$data);
    }
	public function pf_cleaner(Request $request)
    {
		$id = $request->id;
		$f=date('Y-m-d');
		$data['staffs'] = Cleaner::where('id',$id)->first();
		$data['staff_file'] = Cleaner_file::where('cleaner_id',$id)->orderBy('id', 'DESC')->first();
		$data['pf'] = Cleaner_file::where('cleaner_id',$id)->orderBy('id', 'ASC')->get();
		$data['designations'] = Designation::whereIn('id',[23])->get();
		$data['departments'] = Department::orderBy('id', 'ASC')->get();
		$data['locations'] = Location::get();
		$data['shifts'] = Shift::get();
		
		return view('backend.pages.employee.cleaner.pf_insert',$data);
    }
	public function cleaner_file_store(Request $request)
    {
		$data = new Cleaner_file();
			$data->cleaner_id = $request->id;
			$data->execution_date = $request->execution_date;
			$data->type = $request->type;
			$data->designation_id = $request->designation_id;
			$data->jobtype = $request->jobtype;
			$data->location_id = $request->location_id;
			$data->department_id = $request->department_id;
			$data->basic_salary = $request->total_salary/2;
			$data->total_salary = $request->total_salary;
			$data->shift_id = $request->shift_id;
			$data->save();
			
		Toastr::success($request->name. 'Saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
	public function cleaner_file_update(Request $request)
    {
        $data = Cleaner_file::find($request->staff_file_id);
		$data->location_id = $request->location_id;
		$data->save();
		
		Toastr::success($request->name. ' updated successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
    }
	
	// For Security Guard
	public function guard_view(Request $request)
    {
		 $f=date('Y-m-d');
		 if ($request->ajax()) {
		 	
			$sql = "SELECT sh.*, l.*, dpt.*, d.*, f.*, s.* FROM shifts sh, locations l, departments dpt, designations d, guard_files f, guards s, (Select guard_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  guard_files  where execution_date<='".$f."' group by guard_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.guard_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.shift_id=sh.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs pfi" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#PFModal">Edit</button> 
					
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		

		$data['upazilas'] = Upazila::get();
		$data['locations'] = Location::orderBy('id', 'DESC')->get();
		$data['designations'] = Designation::whereIn('id',[6,8,11,14,15,16,18,20])->get();
		$data['departments'] = Department::orderBy('id', 'ASC')->get();
		$data['shifts'] = Shift::get();
		return view('backend.pages.employee.guard.pf',$data);
    }
	public function pf_guard(Request $request)
    {
		$id = $request->id;
		$f=date('Y-m-d');
		$data['staffs'] = Guard::where('id',$id)->first();
		$data['staff_file'] = Guard_file::where('guard_id',$id)->orderBy('id', 'DESC')->first();
		$data['pf'] = Guard_file::where('guard_id',$id)->orderBy('id', 'ASC')->get();
		$data['designations'] = Designation::whereIn('id',[22])->get();
		$data['departments'] = Department::orderBy('id', 'ASC')->get();
		$data['locations'] = Location::get();
		$data['shifts'] = Shift::get();
		
		return view('backend.pages.employee.guard.pf_insert',$data);
    }
	public function guard_file_store(Request $request)
    {
		$data = new Guard_file();
			$data->guard_id = $request->id;
			$data->execution_date = $request->execution_date;
			$data->type = $request->type;
			$data->designation_id = $request->designation_id;
			$data->jobtype = $request->jobtype;
			$data->location_id = $request->location_id;
			$data->department_id = $request->department_id;
			$data->basic_salary = $request->total_salary/2;
			$data->total_salary = $request->total_salary;
			$data->shift_id = $request->shift_id;
			$data->save();
			
		Toastr::success($request->name. 'Saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
}
