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
use App\Models\Guard;
use App\Models\Guard_file;
use App\Models\Cleaner;
use App\Models\Cleaner_file;
use App\Models\Blood_group;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Image;

class StaffController extends Controller
{
    public function staff_view(Request $request)
    {
		 $f=date('Y-m-d');
		 if ($request->ajax()) {
		 	
			//$sql = "SELECT d.*, f.*, s.* FROM designations d, staff_files f, staff s WHERE f.staff_id=s.id AND s.designation_id=d.id order by s.id ASC ";
			$sql = "SELECT l.*, dpt.*, d.*, f.*, s.* FROM locations l, departments dpt, designations d, staff_files f, staff s, (Select staff_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  staff_files  where execution_date<='".$f."' group by staff_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.staff_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('image', function ($data) { 
            		$url= asset('public/images/staff/'.$data->image);
            		return '<img src='.$url.' border="0" width="50" class="rounded-borders" align="center" />';
        		})
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					
					<button type="button" class="btn btn-success btn-xs pfi" id="getEditticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#PFModal">PF</button>
					
					';
                    return $actionBtn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        	}

		$data['upazilas'] = Upazila::get();
		$data['locations'] = Location::orderBy('id', 'DESC')->get();
		$data['designations'] = Designation::whereIn('id',[6,8,11,14,15,16,17,18,19,20,21,24])->get();
		$data['departments'] = Department::orderBy('id', 'ASC')->get();
		$data['shifts'] = Shift::get();
		return view('backend.pages.employee.staff.view',$data);
    }
	
	public function store(Request $request)
    {
		/*
		$request->validate([
			'name'=>'required|unique:categories,name'
		]);
		*/
		$data = new Staff();
			$data->name = $request->name;
			$data->father_name = $request->father_name;
			$data->mother_name = $request->mother_name;
			$data->spouse_name = $request->spouse_name;
			$data->date_of_birth = $request->date_of_birth;
			$data->blood_group = $request->blood_group;
			$data->nid = $request->nid;
			$data->present_address = $request->present_address;
			$data->permanent_address = $request->permanent_address;
			// Image Save
				if($request->hasFile('image')){
					$i=1;
					foreach($request->image as $image){
						//$image = $request->file('image');
						$img = time()+$i . '.' . $image->getClientOriginalExtension();
						$location = public_path('images/staff/' .$img);
						Image::make($image)->save($location)->resize(200, 300);;
						
						//$product_image = new ProductImage;
						//$product_image->stock_id	= $stock->id;
						$data->image		= $img;
						
						$i++;
					}
				}
			$data->joining_date = $request->joining_date;
			$data->designation_id = $request->designation_id;
			$data->phone_1 = $request->phone_1;
			$data->phone_2 = $request->phone_2;
			$data->email = $request->email;
			$data->emergency_contact = $request->emergency_contact;
			$data->save();
		$staff_id = $data->id;
		
		$data = new Staff_file();
			$data->staff_id = $staff_id;
			$data->execution_date = $request->joining_date;
			$data->type = "Joining";
			$data->designation_id = $request->designation_id;
			$data->jobtype = $request->jobtype;
			$data->location_id = $request->location_id;
			$data->department_id = $request->department_id;
			$data->basic_salary = $request->total_salary/2;
			$data->total_salary = $request->total_salary;
			$data->mobile_bill = $request->mobile_bill;
			$data->shift_id = $request->shift_id;
			$data->save();
			
		Toastr::success($request->name. ' saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
	
	public function editstaff(Request $request)
    {
		$id = $request->id;
		
		$data['staffs'] = DB::table('staff')->where('id',$id)->first();
		
		return view('backend.pages.employee.staff.edit',$data);
    }
	public function staff_update(Request $request)
    {
        $data = Staff::find($request->id);
		$data->name  = $request->name;
		$data->father_name  = $request->father_name;
		$data->mother_name  = $request->mother_name;
		$data->phone_1  = $request->phone_1;
		$data->phone_2  = $request->phone_2;
		$data->present_address  = $request->present_address;
		$data->joining_date  = $request->joining_date;
		$data->permanent_address  = $request->permanent_address;
		$data->designation_id  = $request->designation_id;
		$data->email  = $request->email;
		$data->nid  = $request->nid;
		$data->blood_group  = $request->blood_group;
		$data->spouse_name  = $request->spouse_name;
		$data->emergency_contact  = $request->emergency_contact;
		$data->date_of_birth  = $request->date_of_birth;
		$data->save();
		
		Toastr::success($request->name. ' updated successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
    }
	
	// Start Security Guard
	
	public function guard_view(Request $request)
    {
		 $f=date('Y-m-d');
		 if ($request->ajax()) {
		 	
			$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, guard_files f, guards s, (Select guard_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  guard_files  where execution_date<='".$f."' group by guard_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.guard_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('image', function ($data) { 
            		$url= asset('public/images/guard/'.$data->image);
            		return '<img src='.$url.' border="0" width="50" class="img-rounded" align="center" />';
        		})
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					<!--
					<button type="button" class="btn btn-success btn-xs" id="getDeleteData" data-id="'.$data->id.'" data-toggle="modal" data-target="#deleteModal">Delete</button>
					-->
					';
                    return $actionBtn;
                })
               ->rawColumns(['image','action'])
                ->make(true);
        	}
		
		$data['upazilas'] = Upazila::get();
		$data['locations'] = Location::orderBy('id', 'DESC')->get();
		$data['designations'] = Designation::whereIn('id',[22])->get();
		$data['departments'] = Department::orderBy('id', 'ASC')->get();
		$data['shifts'] = Shift::get();
		$data['blood_groups'] = Blood_group::get();
		return view('backend.pages.employee.guard.view',$data);
    }
	public function guard_store(Request $request)
    {
		/*
		$request->validate([
			'name'=>'required|unique:categories,name'
		]);
		*/
		$data = new Guard();
			$data->name = $request->name;
			$data->father_name = $request->father_name;
			$data->mother_name = $request->mother_name;
			$data->spouse_name = $request->spouse_name;
			$data->date_of_birth = $request->date_of_birth;
			$data->blood_group = $request->blood_group;
			$data->nid = $request->nid;
			$data->present_address = $request->present_address;
			$data->permanent_address = $request->permanent_address;
			// Image Save
				if($request->hasFile('image')){
					$i=1;
					foreach($request->image as $image){
						//$image = $request->file('image');
						$img = time()+$i . '.' . $image->getClientOriginalExtension();
						$location = public_path('images/guard/' .$img);
						Image::make($image)->save($location)->resize(200, 300);;
						
						//$product_image = new ProductImage;
						//$product_image->stock_id	= $stock->id;
						$data->image		= $img;
						
						$i++;
					}
				}
			$data->joining_date = $request->joining_date;
			$data->designation_id = $request->designation_id;
			$data->phone_1 = $request->phone_1;
			$data->phone_2 = $request->phone_2;
			$data->emergency_contact = $request->emergency_contact;
			$data->save();
		$guard_id = $data->id;
		
		$data = new Guard_file();
			$data->guard_id = $guard_id;
			$data->execution_date = $request->joining_date;
			$data->type = "Joining";
			$data->designation_id = $request->designation_id;
			$data->jobtype = $request->jobtype;
			$data->location_id = $request->location_id;
			$data->department_id = $request->department_id;
			$data->basic_salary = $request->total_salary/2;
			$data->total_salary = $request->total_salary;
			$data->shift_id = $request->shift_id;
			$data->save();
			
		Toastr::success($request->name. ' saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
	public function editguard(Request $request)
    {
		$id = $request->id;
		
		$data['staffs'] = Guard::where('id',$id)->first();
		
		return view('backend.pages.employee.guard.edit',$data);
    }
	public function guard_update(Request $request)
    {
        $data = Guard::find($request->id);
		$data->name  = $request->name;
		$data->father_name  = $request->father_name;
		$data->mother_name  = $request->mother_name;
		$data->phone_1  = $request->phone_1;
		$data->phone_2  = $request->phone_2;
		$data->present_address  = $request->present_address;
		$data->joining_date  = $request->joining_date;
		$data->permanent_address  = $request->permanent_address;
		$data->designation_id  = $request->designation_id;
		$data->nid  = $request->nid;
		$data->blood_group  = $request->blood_group;
		$data->spouse_name  = $request->spouse_name;
		$data->emergency_contact  = $request->emergency_contact;
		$data->date_of_birth  = $request->date_of_birth;
		$data->save();
		
		Toastr::success($request->name. ' updated successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
    }
	
	// Start Cleaner
	public function cleaner_view(Request $request)
    {
		 $f=date('Y-m-d');
		 if ($request->ajax()) {
		 	
			$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, cleaner_files f, cleaners s, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$f."' group by cleaner_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.cleaner_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('image', function ($data) { 
            		$url= asset('public/images/cleaner/'.$data->image);
            		return '<img src='.$url.' border="0" width="50" class="rounded-borders" align="center" />';
        		})
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					<!--
					<button type="button" class="btn btn-success btn-xs" id="getDeleteData" data-id="'.$data->id.'" data-toggle="modal" data-target="#deleteModal">Delete</button>
					-->
					';
                    return $actionBtn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        	}
		
		$data['upazilas'] = Upazila::get();
		$data['locations'] = Location::orderBy('id', 'DESC')->get();
		$data['designations'] = Designation::whereIn('id',[23])->get();
		$data['departments'] = Department::orderBy('id', 'ASC')->get();
		$data['shifts'] = Shift::get();
		$data['blood_groups'] = Blood_group::get();
		return view('backend.pages.employee.cleaner.view',$data);
    }
	
	public function cleaner_store(Request $request)
    {
		/*
		$request->validate([
			'name'=>'required|unique:categories,name'
		]);
		*/
		$data = new Cleaner();
			$data->name = $request->name;
			$data->father_name = $request->father_name;
			$data->mother_name = $request->mother_name;
			$data->spouse_name = $request->spouse_name;
			$data->date_of_birth = $request->date_of_birth;
			$data->blood_group = $request->blood_group;
			$data->nid = $request->nid;
			$data->present_address = $request->present_address;
			$data->permanent_address = $request->permanent_address;
			// Image Save
				if($request->hasFile('image')){
					$i=1;
					foreach($request->image as $image){
						//$image = $request->file('image');
						$img = time()+$i . '.' . $image->getClientOriginalExtension();
						$location = public_path('images/cleaner/' .$img);
						Image::make($image)->save($location)->resize(200, 300);;
						
						//$product_image = new ProductImage;
						//$product_image->stock_id	= $stock->id;
						$data->image		= $img;
						
						$i++;
					}
				}
			$data->joining_date = $request->joining_date;
			$data->designation_id = $request->designation_id;
			$data->phone_1 = $request->phone_1;
			$data->phone_2 = $request->phone_2;
			$data->emergency_contact = $request->emergency_contact;
			$data->save();
		$cleaner_id = $data->id;
		
		$data = new Cleaner_file();
			$data->cleaner_id = $cleaner_id;
			$data->execution_date = $request->joining_date;
			$data->type = "Joining";
			$data->designation_id = $request->designation_id;
			$data->jobtype = $request->jobtype;
			$data->location_id = $request->location_id;
			$data->department_id = $request->department_id;
			$data->basic_salary = $request->total_salary/2;
			$data->total_salary = $request->total_salary;
			$data->shift_id = $request->shift_id;
			$data->save();
			
		Toastr::success($request->name. ' saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
	
	public function editcleaner(Request $request)
    {
		$id = $request->id;
		
		$data['staffs'] = Cleaner::where('id',$id)->first();
		
		return view('backend.pages.employee.cleaner.edit',$data);
    }
	public function cleaner_update(Request $request)
    {
        $data = Cleaner::find($request->id);
		$data->name  = $request->name;
		$data->father_name  = $request->father_name;
		$data->mother_name  = $request->mother_name;
		$data->phone_1  = $request->phone_1;
		$data->phone_2  = $request->phone_2;
		$data->present_address  = $request->present_address;
		$data->joining_date  = $request->joining_date;
		$data->permanent_address  = $request->permanent_address;
		$data->designation_id  = $request->designation_id;
		$data->nid  = $request->nid;
		$data->blood_group  = $request->blood_group;
		$data->spouse_name  = $request->spouse_name;
		$data->emergency_contact  = $request->emergency_contact;
		$data->date_of_birth  = $request->date_of_birth;
		$data->save();
		
		Toastr::success($request->name. ' updated successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
    }
}
