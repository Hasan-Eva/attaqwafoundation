<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Journal;
use App\Models\Ac_head;
use App\Models\Branch;
use App\Models\Salary_staff;
use Toastr;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use PDF;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function view()
    {
        return view('backend.pages.accounts.journal');
    }
	
	public function index(Request $request)
    {
         if ($request->ajax()) {
			$sql = "SELECT a.*, b.*, a.h_name as dr, b.h_name as cr, j.* FROM ac_heads a, ac_heads b, journals j WHERE a.id=j.dr_head AND b.id=j.cr_head order by j.id DESC ";
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('j_date', function($row){
				  return date('d-m-y', strtotime($row->j_date));
				})
                ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" href="#" class="edit btn btn-info btn-xs edit" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button> 
							<button type="button" href="#" class="edit btn btn-danger btn-xs delete" data-id="'.$row->id.'" data-toggle="modal" data-target="#deleteModal"><i class="fas fa-trash"></i></button> 
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		$data['dr_heads'] = Ac_head::whereIn('role',[0,1])->get();
		$data['cr_heads'] = Ac_head::whereIn('role',[1,2])->get();
		return view('backend.pages.accounts.view',$data);
    }
	
	
	public function store(Request $request)
    {
			
		if($request->dr_cash_1!=NULL){$dr_cash_1=$request->dr_cash_1;} else {$dr_cash_1=0;}
		if($request->dr_cash_2!=NULL){$dr_cash_2=$request->dr_cash_2;} else {$dr_cash_2=0;}
		if($request->cr_cash_1!=NULL){$cr_cash_1=$request->cr_cash_1;} else {$cr_cash_1=0;}
		if($request->cr_cash_2!=NULL){$cr_cash_2=$request->cr_cash_2;} else {$cr_cash_2=0;}
		
		$data=array();
			$data['j_date'] =  $request->j_date;
			$data['dr_head'] = $request->dr_head_1;
			$data['amount'] = $dr_cash_1;
			$data['cr_head'] = $request->cr_head_1;
			$data['transactionwith'] = $request->transactionwith;
			$data['particulars'] = $request->particulars;
			$data['ref_no'] = $request->ref_no;
			DB::table('journals')->insert($data);
		/*
		$ac_head = new Journal;
	   	$ac_head->j_date = $request->j_date;
	   	$ac_head->dr_head = $request->dr_head_1;
	   	$ac_head->amount = $dr_cash_1;
		$ac_head->cr_head = $request->cr_head_1;
		$ac_head->particulars = $request->particulars;
		$ac_head->save();
		
		if($request->dr_head_2){
		$ac_head = new Journal;
	   	$ac_head->j_date = $request->j_date;
	   	$ac_head->dr_head = $request->dr_head_2;
		$ac_head->pay_type_id = $request->pay_type_id;
	   	$ac_head->amount = $dr_cash_2;
		$ac_head->cr_head = $request->cr_head_2;
		$ac_head->particulars = $request->particulars;
		$ac_head->save();
		}
		*/
		Session()->flash('success','Journal has been saved Successfully !!');	
	   return redirect()->back();
    }
	
	public function editjournal(Request $request)
    {
		$id = $request->id;
		
		$data['journals'] = DB::table('journals')->where('id',$id)->first();
		
		return view('backend.pages.accounts.edit',$data);
    }
	
	public function update(Request $request)
    {
        $data = Journal::find($request->id);
		$data->j_date  = $request->j_date;
		$data->transactionwith  = $request->transactionwith;
		$data->particulars  = $request->particulars;
		$data->ref_no  = $request->ref_no;
		$data->dr_head  = $request->dr_head_1;
		$data->cr_head  = $request->cr_head_1;
		$data->amount  = $request->dr_cash_1;
		$data->save();
		
		Toastr::success(' updated successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
    }
	
	public function salary(Request $request)
    {
         if ($request->ajax()) {
			$sql = "SELECT a.*, j.*, b.*, a.h_name as dr, b.h_name as cr FROM ac_heads a, ac_heads b, journals j WHERE a.id=j.dr_head AND b.id=j.cr_head AND j.dr_head IN (15, 16, 17, 18) order by j.id DESC ";
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<button type="button" href="#" class="edit btn btn-info btn-xs" data-id="'.$row->id.'" data-toggle="modal" data-target="#editModal"><i class="fas fa-edit"></i></button> <a href="#" class="delete btn btn-danger btn-xs"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		$data['dr_heads'] = Ac_head::whereIn('role',[0,1])->get();
		$data['cr_heads'] = Ac_head::whereIn('role',[1,2])->get();
		return view('backend.pages.accounts.salary_view',$data);
    }
	public function salary_view(Request $request)
	{
		$month=Salary_staff::where('month',$request->month)->first();
		if(isset($month)){
			Toastr::success('Sorry !! Data Allready Exist', 'Title', ["positionClass" => "toast-top-right"]);
			return redirect()->back();
		} else {
			$f=$request->month;
			$sql = "SELECT l.*, dpt.*, d.*, f.*, s.* FROM locations l, departments dpt, designations d, staff_files f, staff s, (Select staff_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  staff_files  where execution_date<='".$f."' group by staff_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.staff_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
			
			$data['staffs']=DB::select($sql);
			$data['t_date']=$request->t_date;
			$data['month']=$request->month;
			return view('backend.pages.accounts.salary',$data);
		}
	}
	public function salary_store(Request $request)
	{
		$count_id = count($request->id);
			for($i=0; $i<$count_id; $i++){
					/*
					$stock = Stock::Where ('product_id', $request->product_id[$i])
						->Where ('brand_id', $request->brand_id[$i])
						->Where ('color_id', $request->color_id[$i])
						->Where ('size_id', $request->size_id[$i])->first();
					
					$data = Stock::find($stock->id);
					$qty = $data->balance + $request->buying_qty[$i];
					$cost = $data->cost_of_fund + $request->buying_price[$i];	
					
					$data = Stock::find($stock->id);
					$data->balance = $qty;
					$data->cost_of_fund = $cost;
					$data->save();
					*/
					$data = new Salary_staff;
					$data->salary_date = $request->t_date;
					$data->staff_id = $request->id[$i];
					$data->designation_id = $request->designation_id[$i];
					$data->month =$request->month;
					$data->type = "Salary";
					$data->amount = $request->amount[$i];
					$data->mobile = $request->mobile[$i];
					$data->advance = $request->advance[$i];
					$data->absent = $request->absent[$i];
					$data->total = $request->total_salary[$i];
					$data->save();
					}			
		Toastr::success('Journal saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
	   	return redirect()->route('journal_salary.view');
	}
	
	public function ledger()
	{
		$data['ac_heads'] = Ac_head::get();
		return view('backend.pages.accounts.ledger1',$data);
	}
	
	public function ledger_data(Request $request)
	{
		
		$data['head']=$request->h_name;
		$data['f']=$request->f_date;
		$data['t']=$request->t_date;
		$data['ac_heads'] = Ac_head::get();
		$data['opening_dr'] = Journal::Where ('dr_head', $request->h_name)->where('j_date','<',$request->f_date)->sum('amount');
		$data['opening_cr'] = Journal::Where ('cr_head', $request->h_name)->where('j_date','<',$request->f_date)->sum('amount');
		$sql="SELECT h.*, j.*,(SELECT h.h_name from ac_heads h where j.dr_head=h.id) as dr_name, (SELECT h.h_name from ac_heads h where j.cr_head=h.id) as cr_name FROM ac_heads h, journals j WHERE h.id=j.dr_head AND j.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' AND (j.dr_head='".$request->h_name."' OR j.cr_head='".$request->h_name."') ";
		$data['cr']=DB::select($sql);
		
		return view('backend.pages.accounts.ledger1', $data);
	}
	public function ledger_pdf(Request $request)
	{
		
		$data['head']=$request->h_name;
		$data['f']=$request->f_date;
		$data['t']=$request->t_date;
		$data['ac_heads'] = Ac_head::get();
		$data['opening_dr'] = Journal::Where ('dr_head', $request->h_name)->where('j_date','<',$request->f_date)->sum('amount');
		$data['opening_cr'] = Journal::Where ('cr_head', $request->h_name)->where('j_date','<',$request->f_date)->sum('amount');
		$sql="SELECT h.*, j.*,(SELECT h.h_name from ac_heads h where j.dr_head=h.id) as dr_name, (SELECT h.h_name from ac_heads h where j.cr_head=h.id) as cr_name FROM ac_heads h, journals j WHERE h.id=j.dr_head AND j.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' AND (j.dr_head='".$request->h_name."' OR j.cr_head='".$request->h_name."') ";
		$data['cr']=DB::select($sql);
		
		$pdf = PDF::loadView('backend.pages.accounts.pdf.ledger_pdf',$data);
		return $pdf->stream('ledger.pdf');
	}
	
	public function voucher(Request $request)
	{
		$data['f']=$request->f_date;
		$data['t']=$request->t_date;
		$data['ac_heads'] = Ac_head::get();
		$sql="SELECT h.*, j.*,(SELECT h.h_name from ac_heads h where j.dr_head=h.id) as dr_name, (SELECT h.h_name from ac_heads h where j.cr_head=h.id) as cr_name FROM ac_heads h, journals j WHERE h.id=j.dr_head AND j.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' ";
		$data['voucher']=DB::select($sql);
		
		return view('backend.pages.accounts.ledger1', $data);
	}
	
	public function trailbalance_view(Request $request)
	{		
		$sql="SELECT 
		(SELECT SUM(amount) from journals Where dr_head=2 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as capital_dr,
		(SELECT SUM(amount) from journals Where cr_head=2 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as capital_cr,
		(SELECT SUM(amount) from journals Where dr_head=3 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as cash_dr,
		(SELECT SUM(amount) from journals Where cr_head=3 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as cash_cr,
		(SELECT SUM(amount) from journals Where dr_head=4 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bank_dr,
		(SELECT SUM(amount) from journals Where cr_head=4 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bank_cr,
		(SELECT SUM(amount) from journals Where dr_head=5 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_manager,
		(SELECT SUM(amount) from journals Where dr_head=6 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_civil,
		(SELECT SUM(amount) from journals Where dr_head=7 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_it,
		(SELECT SUM(amount) from journals Where dr_head=8 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_reception,
		(SELECT SUM(amount) from journals Where dr_head=9 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_electrical,
		(SELECT SUM(amount) from journals Where dr_head=10 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_asst_electrical,
		(SELECT SUM(amount) from journals Where dr_head=11 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_store_incharge,
		(SELECT SUM(amount) from journals Where dr_head=12 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_store_keeper,
		(SELECT SUM(amount) from journals Where dr_head=13 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_bm_asst,
		(SELECT SUM(amount) from journals Where dr_head=14 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_imam,
		(SELECT SUM(amount) from journals Where dr_head=15 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_gardener,
		(SELECT SUM(amount) from journals Where dr_head=16 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_guard_office,
		(SELECT SUM(amount) from journals Where dr_head=17 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_guard_aegis,
		(SELECT SUM(amount) from journals Where dr_head=18 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_cleaner,
		(SELECT SUM(amount) from journals Where dr_head=19 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as electric_bill,
		(SELECT SUM(amount) from journals Where cr_head=20 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as supply_water_bill,
		(SELECT SUM(amount) from journals Where dr_head=21 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as drinking_water_bill,
		(SELECT SUM(amount) from journals Where cr_head=22 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as entertainment,
		(SELECT SUM(amount) from journals Where dr_head=24 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as internet_bill,
		(SELECT SUM(amount) from journals Where dr_head=25 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as house_rent,
		(SELECT SUM(amount) from journals Where dr_head=26 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as garbage_bill,
		(SELECT SUM(amount) from journals Where dr_head=27 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as pest_control_bill,
		(SELECT SUM(amount) from journals Where cr_head=28 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as generator_service,
		(SELECT SUM(amount) from journals Where cr_head=29 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as lift_service,
		(SELECT SUM(amount) from journals Where cr_head=30 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bms_service,
		(SELECT SUM(amount) from journals Where dr_head=31 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as generator_fuel,
		(SELECT SUM(amount) from journals Where dr_head=32 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fire_pump_fuel,
		(SELECT SUM(amount) from journals Where dr_head=33 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as toilet_stationary,
		(SELECT SUM(amount) from journals Where dr_head=34 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as cleaning_equipment_meterials,
		(SELECT SUM(amount) from journals Where dr_head=36 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as transport_bill,
		(SELECT SUM(amount) from journals Where dr_head=37 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as water_reservoir_clean,
		(SELECT SUM(amount) from journals Where dr_head=38 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as ip_camera_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=39 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fire_hydrant,
		(SELECT SUM(amount) from journals Where dr_head=40 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as carrying_bill,
		(SELECT SUM(amount) from journals Where dr_head=41 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as exhaust_fan,
		(SELECT SUM(amount) from journals Where dr_head=42 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as led_light,
		(SELECT SUM(amount) from journals Where dr_head=43 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fire_extinguisher,
		(SELECT SUM(amount) from journals Where dr_head=44 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as miscellaneous,
		(SELECT SUM(amount) from journals Where dr_head=45 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as generator_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=46 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as lift_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=47 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as ac_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=48 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as epoxy_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=49 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as water_pump_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=50 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as electrical_work,
		(SELECT SUM(amount) from journals Where dr_head=51 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as wooden_work,
		(SELECT SUM(amount) from journals Where dr_head=52 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as glass_work,
		(SELECT SUM(amount) from journals Where dr_head=53 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as metal_work,
		(SELECT SUM(amount) from journals Where dr_head=54 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as plumbing_work,
		(SELECT SUM(amount) from journals Where dr_head=55 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as tiles_work,
		(SELECT SUM(amount) from journals Where dr_head=56 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as civil_work,
		(SELECT SUM(amount) from journals Where dr_head=57 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fair_face_treatment,
		(SELECT SUM(amount) from journals Where dr_head=58 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as miscellaneous_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=59 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as signage,
		(SELECT SUM(amount) from journals Where dr_head=60 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as garden_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=61 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bank_charge";
	 
	 	$data['trailbalance']=DB::select($sql);
		
		return view('backend.pages.accounts.ledger1', $data);
	}
	
	public function balancesheet_view(Request $request)
	{		
		$sql="SELECT 
		(SELECT SUM(amount) from journals Where dr_head=2 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as capital_dr,
		(SELECT SUM(amount) from journals Where cr_head=2 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as capital_cr,
		(SELECT SUM(amount) from journals Where dr_head=3 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as cash_dr,
		(SELECT SUM(amount) from journals Where cr_head=3 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as cash_cr,
		(SELECT SUM(amount) from journals Where dr_head=4 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bank_dr,
		(SELECT SUM(amount) from journals Where cr_head=4 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bank_cr,
		(SELECT SUM(amount) from journals Where dr_head=5 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_manager,
		(SELECT SUM(amount) from journals Where dr_head=6 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_civil,
		(SELECT SUM(amount) from journals Where dr_head=7 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_it,
		(SELECT SUM(amount) from journals Where dr_head=8 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_reception,
		(SELECT SUM(amount) from journals Where dr_head=9 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_electrical,
		(SELECT SUM(amount) from journals Where dr_head=10 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_asst_electrical,
		(SELECT SUM(amount) from journals Where dr_head=11 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_store_incharge,
		(SELECT SUM(amount) from journals Where dr_head=12 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_store_keeper,
		(SELECT SUM(amount) from journals Where dr_head=13 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_bm_asst,
		(SELECT SUM(amount) from journals Where dr_head=14 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_imam,
		(SELECT SUM(amount) from journals Where dr_head=15 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_gardener,
		(SELECT SUM(amount) from journals Where dr_head=16 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_guard_office,
		(SELECT SUM(amount) from journals Where dr_head=17 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_guard_aegis,
		(SELECT SUM(amount) from journals Where dr_head=18 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_cleaner,
		(SELECT SUM(amount) from journals Where dr_head=19 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as electric_bill,
		(SELECT SUM(amount) from journals Where cr_head=20 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as supply_water_bill,
		(SELECT SUM(amount) from journals Where dr_head=21 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as drinking_water_bill,
		(SELECT SUM(amount) from journals Where cr_head=22 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as entertainment,
		(SELECT SUM(amount) from journals Where dr_head=24 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as internet_bill,
		(SELECT SUM(amount) from journals Where dr_head=25 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as house_rent,
		(SELECT SUM(amount) from journals Where dr_head=26 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as garbage_bill,
		(SELECT SUM(amount) from journals Where dr_head=27 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as pest_control_bill,
		(SELECT SUM(amount) from journals Where cr_head=28 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as generator_service,
		(SELECT SUM(amount) from journals Where cr_head=29 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as lift_service,
		(SELECT SUM(amount) from journals Where cr_head=30 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bms_service,
		(SELECT SUM(amount) from journals Where dr_head=31 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as generator_fuel,
		(SELECT SUM(amount) from journals Where dr_head=32 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fire_pump_fuel,
		(SELECT SUM(amount) from journals Where dr_head=33 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as toilet_stationary,
		(SELECT SUM(amount) from journals Where dr_head=34 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as cleaning_equipment_meterials,
		(SELECT SUM(amount) from journals Where dr_head=36 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as transport_bill,
		(SELECT SUM(amount) from journals Where dr_head=37 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as water_reservoir_clean,
		(SELECT SUM(amount) from journals Where dr_head=38 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as ip_camera_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=39 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fire_hydrant,
		(SELECT SUM(amount) from journals Where dr_head=40 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as carrying_bill,
		(SELECT SUM(amount) from journals Where dr_head=41 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as exhaust_fan,
		(SELECT SUM(amount) from journals Where dr_head=42 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as led_light,
		(SELECT SUM(amount) from journals Where dr_head=43 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fire_extinguisher,
		(SELECT SUM(amount) from journals Where dr_head=44 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as miscellaneous,
		(SELECT SUM(amount) from journals Where dr_head=45 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as generator_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=46 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as lift_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=47 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as ac_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=48 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as epoxy_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=49 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as water_pump_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=50 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as electrical_work,
		(SELECT SUM(amount) from journals Where dr_head=51 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as wooden_work,
		(SELECT SUM(amount) from journals Where dr_head=52 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as glass_work,
		(SELECT SUM(amount) from journals Where dr_head=53 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as metal_work,
		(SELECT SUM(amount) from journals Where dr_head=54 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as plumbing_work,
		(SELECT SUM(amount) from journals Where dr_head=55 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as tiles_work,
		(SELECT SUM(amount) from journals Where dr_head=56 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as civil_work,
		(SELECT SUM(amount) from journals Where dr_head=57 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fair_face_treatment,
		(SELECT SUM(amount) from journals Where dr_head=58 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as miscellaneous_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=59 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as signage,
		(SELECT SUM(amount) from journals Where dr_head=60 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as garden_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=61 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bank_charge
		 
		"; 
	 
	 	$data['balancesheet']=DB::select($sql);
		/*
		$t=date("Y-m-d 23:59:59", strtotime($request->t_date)) ;
		$sql = "SELECT SUM(t.invest) as inventory FROM trades t, stocks s, (Select stock_id, MAX(id) as maxid, MAX(created_at)as maxdate from  trades  where created_at<='".$t."' group by stock_id)g WHERE s.id=t.stock_id AND t.id=g.maxid AND t.created_at=g.maxdate AND t.created_at<='".$t."' order by s.id ASC ";
		$data['stocks']=DB::select($sql);
		
		
		$sql = "SELECT SUM(c.total_price) as totalprice, SUM(c.advance) as avdance, SUM(c.courier_charge) as courier_charge FROM customer_orders c WHERE c.confirm_status=1 AND c.status=4 AND c.courier_id=1 order by c.id ASC ";
		$data['pathaos']=DB::select($sql);
		
		
		
		$sql = "SELECT SUM(c.total_price) as totalprice, SUM(c.advance) as avdance, SUM(c.courier_charge) as courier_charge FROM customer_orders c WHERE c.confirm_status=1 AND c.status=4 order by c.id ASC ";
		$data['totals']=DB::select($sql);
		*/
		return view('backend.pages.accounts.ledger1', $data);
	}
	
	public function expense_pdf(Request $request)
	{		
		$sql="SELECT 
		(SELECT SUM(amount) from journals Where dr_head=2 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as capital_dr,
		(SELECT SUM(amount) from journals Where cr_head=2 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as capital_cr,
		(SELECT SUM(amount) from journals Where dr_head=3 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as cash_dr,
		(SELECT SUM(amount) from journals Where cr_head=3 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as cash_cr,
		(SELECT SUM(amount) from journals Where dr_head=4 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bank_dr,
		(SELECT SUM(amount) from journals Where cr_head=4 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bank_cr,
		(SELECT SUM(amount) from salary_staffs Where staff_id=1 AND salary_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_manager,
		(SELECT SUM(amount) from journals Where dr_head=6 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_civil,
		(SELECT SUM(amount) from journals Where dr_head=7 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_it,
		(SELECT SUM(amount) from journals Where dr_head=8 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_reception,
		(SELECT SUM(amount) from journals Where dr_head=9 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_electrician,
		(SELECT SUM(amount) from journals Where dr_head=10 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_asst_electrician,
		(SELECT SUM(amount) from journals Where dr_head=11 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_store_incharge,
		(SELECT SUM(amount) from journals Where dr_head=12 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_store_keeper,
		(SELECT SUM(amount) from journals Where dr_head=13 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_bm_asst,
		(SELECT SUM(amount) from journals Where dr_head=14 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_imam,
		(SELECT SUM(amount) from journals Where dr_head=66 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_gardener,
		(SELECT SUM(amount) from journals Where dr_head=16 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_guard_office,
		(SELECT SUM(amount) from journals Where dr_head=17 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_guard_aegis,
		(SELECT SUM(amount) from journals Where dr_head=18 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as salary_cleaner,
		(SELECT SUM(amount) from journals Where dr_head=19 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as electric_bill,
		(SELECT SUM(amount) from journals Where dr_head=20 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as supply_water_bill,
		(SELECT SUM(amount) from journals Where dr_head=21 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as drinking_water_bill,
		(SELECT SUM(amount) from journals Where cr_head=22 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as entertainment,
		(SELECT SUM(amount) from journals Where dr_head=24 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as internet_bill,
		(SELECT SUM(amount) from journals Where dr_head=25 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as house_rent,
		(SELECT SUM(amount) from journals Where dr_head=26 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as garbage_bill,
		(SELECT SUM(amount) from journals Where dr_head=27 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as pest_control_bill,
		(SELECT SUM(amount) from journals Where dr_head=28 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as generator_service,
		(SELECT SUM(amount) from journals Where dr_head=29 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as lift_service,
		(SELECT SUM(amount) from journals Where dr_head=30 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bms_service,
		(SELECT SUM(amount) from journals Where dr_head=31 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as generator_fuel,
		(SELECT SUM(amount) from journals Where dr_head=32 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fire_pump_fuel,
		(SELECT SUM(amount) from journals Where dr_head=33 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as toilet_stationary,
		(SELECT SUM(amount) from journals Where dr_head=34 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as cleaning_equipment_meterials,
		(SELECT SUM(amount) from journals Where dr_head=36 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as transport_bill,
		(SELECT SUM(amount) from journals Where dr_head=37 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as water_reservoir_clean,
		(SELECT SUM(amount) from journals Where dr_head=38 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as ip_camera_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=39 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fire_hydrant,
		(SELECT SUM(amount) from journals Where dr_head=40 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as carrying_bill,
		(SELECT SUM(amount) from journals Where dr_head=41 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as exhaust_fan,
		(SELECT SUM(amount) from journals Where dr_head=42 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as led_light,
		(SELECT SUM(amount) from journals Where dr_head=43 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fire_extinguisher,
		(SELECT SUM(amount) from journals Where dr_head=44 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as miscellaneous,
		(SELECT SUM(amount) from journals Where dr_head=45 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as generator_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=46 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as lift_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=47 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as ac_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=48 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as epoxy_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=49 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as water_pump_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=50 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as electrical_work,
		(SELECT SUM(amount) from journals Where dr_head=51 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as wooden_work,
		(SELECT SUM(amount) from journals Where dr_head=52 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as glass_work,
		(SELECT SUM(amount) from journals Where dr_head=53 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as metal_work,
		(SELECT SUM(amount) from journals Where dr_head=54 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as plumbing_work,
		(SELECT SUM(amount) from journals Where dr_head=55 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as tiles_work,
		(SELECT SUM(amount) from journals Where dr_head=56 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as civil_work,
		(SELECT SUM(amount) from journals Where dr_head=57 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as fair_face_treatment,
		(SELECT SUM(amount) from journals Where dr_head=58 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as miscellaneous_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=59 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as signage,
		(SELECT SUM(amount) from journals Where dr_head=60 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as garden_maintenance,
		(SELECT SUM(amount) from journals Where dr_head=61 AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as bank_charge,
		(SELECT SUM(amount) from journals Where dr_head IN (27,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60) AND j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."')as all_maintenance
		";
	 
	 	$data['expense']=DB::select($sql);
		
		$sql = "SELECT count(c.id) as cleaner_no FROM cleaners c, cleaner_files f, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$request->t_date."' group by cleaner_id)g WHERE c.id=f.cleaner_id AND f.id=g.maxid AND f.execution_date=g.maxdate AND f.execution_date<='".$request->t_date."' AND f.type!='Released' order by c.id ASC ";
		$data['cleaners']=DB::select($sql);
		
		// For Salary Query
		//$sql="SELECT SUM(a.total) as totalamount, b.name, c.designation_name from salary_staffs a, staff b, designations c Where a.staff_id=b.id AND b.designation_id=c.id AND a.salary_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' group by a.id ";
		  $sql="SELECT SUM(a.total + a.advance) as totalamount, a.designation_id, c.designation_name from salary_staffs a, designations c Where a.designation_id=c.id AND a.salary_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' group by a.designation_id ";
		$data['salary']=DB::select($sql);
		
		$data['month_1']=Salary_staff::whereBetween('salary_date',[$request->f_date, $request->t_date])->orderBy('month','asc')->first();
		$data['month_2']=Salary_staff::whereBetween('salary_date',[$request->f_date, $request->t_date])->orderBy('month','desc')->first();
		
		// For staff count
		$sql="SELECT count(DISTINCT designation_id) as totalstaff from salary_staffs Where salary_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' order by designation_id";
		
		$data['staff_count']=DB::select($sql);
		
		// For maintenance 
		$sql="SELECT SUM(a.amount) as dramount, a.dr_head as drhead, b.h_name from journals a, ac_heads b Where a.dr_head=b.id AND a.dr_head!=3 AND a.dr_head IN (38,45,46,47,48,49,58,60) AND a.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' group by a.dr_head ";
		
		$data['maintenances']=DB::select($sql);
		
		$data['maintenance_count'] = Journal::distinct()->select('dr_head')->whereIn('dr_head', [38,45,46,47,48,49,58,60])->whereBetween('j_date', [$request->f_date,$request->t_date])->groupBy('dr_head')->get();
		// End
		// For Miscellaneous expenses 
		$sql="SELECT SUM(a.amount) as dramount, a.dr_head as drhead, b.h_name from journals a, ac_heads b Where a.dr_head=b.id AND a.dr_head NOT IN (2,3,4,6,7,15,16,17,18,19,20,24,28,29,30,31,32,33,34,38,45,46,47,48,49,58,60,63,64) AND a.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' group by a.dr_head ";
		
		$data['miscellaneous_expenses']=DB::select($sql);
		
		$data['miscellaneous_count'] = Journal::distinct()->select('dr_head')->whereNotIn('dr_head', [2,3,4,6,7,15,16,17,18,19,20,28,29,30,31,32,33,34,38,45,46,47,48,49,58,60,63,64])->whereBetween('j_date', [$request->f_date,$request->t_date])->groupBy('dr_head')->get();
		// End
		
		$sql="SELECT SUM(a.amount) as dramount, a.dr_head as drhead, b.h_name from journals a, ac_heads b Where a.dr_head=b.id AND a.dr_head!=3 AND a.dr_head IN (16,17) AND a.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' group by a.dr_head ";
		
		$data['guards']=DB::select($sql);
		
		$sql="SELECT SUM(a.amount) as dramount, a.dr_head as drhead, b.h_name from journals a, ac_heads b Where a.dr_head=b.id AND a.dr_head!=3 AND a.dr_head IN (18) AND a.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' group by a.dr_head ";
		
		$data['cleaner']=DB::select($sql);
		
		$sql="SELECT SUM(a.amount) as dramount, a.dr_head as drhead, b.h_name from journals a, ac_heads b Where a.dr_head=b.id AND a.dr_head!=3 AND a.dr_head NOT IN (5,6,7,8,9,10,11,12,13,14,15,16,17,18,66) AND a.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' group by a.dr_head ";
		
		$data['expt']=DB::select($sql);
		
		$sql="SELECT SUM(a.amount) as dramount, a.dr_head as drhead, b.h_name from journals a, ac_heads b Where a.dr_head=b.id AND a.dr_head NOT IN (2,3,4) AND a.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' group by a.dr_head ";
		
		$data['exp']=DB::select($sql);
		/*
		$pdf = PDF::loadView('backend.pages.accounts.pdf.expense_pdf',$data);
		return $pdf->stream('expense.pdf');
		*/
		return view('backend.pages.accounts.expense', $data);
	}
	
	public function paysheet_pdf(Request $request)
	{		
		$first_date = date('Y-m-01', strtotime($request->f_date));
		$data['fss']=$first_date;
		
		
		$data['f']=$request->f_date;
		$data['t']=$request->t_date;
		$data['ac_heads'] = Ac_head::get();
		//$data['opening_dr'] = Journal::Where ('dr_head', 3)->where('j_date','>=',$first_date)->where('j_date','<',$request->f_date)->sum('amount'); // For Monthly opening zero
		//$data['opening_cr'] = Journal::Where ('cr_head', 3)->where('j_date','>=',$first_date)->where('j_date','<',$request->f_date)->sum('amount'); // For Monthly opening zero
		$data['opening_dr'] = Journal::Where ('dr_head', 3)->where('j_date','<',$request->f_date)->sum('amount');
		$data['opening_cr'] = Journal::Where ('cr_head', 3)->where('j_date','<',$request->f_date)->sum('amount');
		
		$data['cash_received'] = Journal::Where ('cr_head', 63)->where ('dr_head', 3)->whereBetween('j_date', [$request->f_date, $request->t_date])->sum('amount');
		
		$data['bank_dr'] = Journal::Where ('dr_head', 4)->where('j_date','<',$request->f_date)->sum('amount');
		$data['bank_cr'] = Journal::Where ('cr_head', 4)->where('j_date','<',$request->f_date)->sum('amount');
		$data['bank_charge_previous'] = Journal::Where ('dr_head', 61)->where('j_date','<',$request->f_date)->sum('amount');
		$data['bank_received_dr'] = Journal::where ('dr_head', 4)->whereBetween('j_date', [$request->f_date, $request->t_date])->sum('amount');
		$data['bank_received_cr'] = Journal::Where ('cr_head', 4)->whereBetween('j_date', [$request->f_date, $request->t_date])->sum('amount');
		$data['bank_cgarge_current'] = Journal::where ('dr_head', 61)->whereBetween('j_date', [$request->f_date, $request->t_date])->sum('amount');
		
		$sql="SELECT h.*, j.*,(SELECT h.h_name from ac_heads h where j.dr_head=h.id) as dr_name, (SELECT h.h_name from ac_heads h where j.cr_head=h.id) as cr_name FROM ac_heads h, journals j WHERE j.dr_head!=3 AND j.cr_head!=64 AND h.id=j.dr_head AND j.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' order by j.j_date ASC ";
		$data['cr']=DB::select($sql);
		
		$sql="SELECT h.*, j.*,(SELECT h.h_name from ac_heads h where j.dr_head=h.id) as dr_name, (SELECT h.h_name from ac_heads h where j.cr_head=h.id) as cr_name FROM ac_heads h, journals j WHERE j.dr_head!=3 AND j.cr_head=64 AND h.id=j.dr_head AND j.j_date BETWEEN '".$request->f_date."' AND '".$request->t_date."' order by j.j_date ASC ";
		$data['cheque']=DB::select($sql);
		
		$pdf = PDF::loadView('backend.pages.accounts.pdf.paysheet_pdf',$data);
		return $pdf->stream('paysheet.pdf');
	}
}
