<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Journal;
use App\Models\Ac_head;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Trade;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use PDF;

class ReportController extends Controller
{
    // Start Purchase 
	public function view(Request $request)
	{
		return view('backend.pages.report.inventory.view');
	}
	public function purchase(Request $request)
	{
		$data['purchase'] = Trade::whereBetween('date',[$request->f_date, $request->t_date])->where('type','Purchase')->get();
		return view('backend.pages.report.inventory.view',$data);
	}
	//pdf
	public function purchase_pdf(Request $request)
	{
		$data['f_date']=$request->f_date;
		$data['t_date']=$request->t_date;
		$data['purchase'] = Trade::whereBetween('date',[$request->f_date, $request->t_date])->where('type','Purchase')->get();
		
		$pdf = PDF::loadView('backend.pages.report.inventory.pdf.purchase_pdf',$data);
		return $pdf->stream('purchase.pdf');
	}
	// End Purchase
	
	// Start Stock
	public function stock_view(Request $request)
	{
		return view('backend.pages.report.stock.view');
	}
	public function stock(Request $request)
	{
		$f=$request->f_date;
		$t=$request->t_date;
		$sql = "SELECT c.*, p.*, b.*, s.*, s.id as sid, t.*, cl.*, si.*, pt.* FROM categories c, products p, brands b, stocks s, trades t, colors cl, sizes si, subcategories pt, (Select stock_id, MAX(id) as maxid, MAX(created_at)as maxdate from  trades  where date<='".$f."' group by stock_id)g WHERE s.id=t.stock_id AND t.id=g.maxid AND t.created_at=g.maxdate AND p.category_id=c.id AND s.product_id=p.id AND s.brand_id=b.id AND s.color_id=cl.id AND s.size_id=si.id AND p.subcategory_id=pt.id AND t.date<='".$f."' AND s.balance>0 order by pt.id ASC ";
		$data['stocks']=DB::select($sql);
		return view('backend.pages.report.stock.view',$data);
	}
	public function stock_pdf(Request $request)
	{
		$f=$request->f_date;
		$data['f_date']=$request->f_date;
		$sql = "SELECT c.*, p.*, b.*, s.*, s.id as sid, t.*, cl.*, si.*, pt.*, u.* FROM categories c, products p, brands b, stocks s, trades t, colors cl, sizes si, subcategories pt, units u, (Select stock_id, MAX(id) as maxid, MAX(created_at)as maxdate from  trades  where date<='".$f."' group by stock_id)g WHERE s.id=t.stock_id AND t.id=g.maxid AND t.created_at=g.maxdate AND p.category_id=c.id AND s.product_id=p.id AND s.brand_id=b.id AND s.color_id=cl.id AND s.size_id=si.id AND p.unit_id=u.id AND p.subcategory_id=pt.id AND t.date<='".$f."' AND s.balance>0 order by pt.id ASC ";
		$data['stocks']=DB::select($sql);
		//return view('backend.pages.report.stock.view',$data);
		
		$pdf = PDF::loadView('backend.pages.report.stock.pdf.stock_pdf',$data);
		return $pdf->stream('Stock.pdf');
	}
	
	// End Stock
	
	public function issue_view(Request $request)
	{
		return view('backend.pages.report.product_issue.view');
	}
	public function issue(Request $request)
	{
		$data['purchase'] = Trade::whereBetween('date',[$request->f_date, $request->t_date])->where('type','Issue')->get();
		return view('backend.pages.report.product_issue.view',$data);
	}
	public function issue_pdf(Request $request)
	{
		$data['f_date']=$request->f_date;
		$data['t_date']=$request->t_date;
		$data['issue'] = Trade::whereBetween('date',[$request->f_date, $request->t_date])->where('type','Issue')->get();
		
		$pdf = PDF::loadView('backend.pages.report.product_issue.pdf.issue_pdf',$data);
		return $pdf->stream('issue.pdf');
	}
	
	// Start Staff Report
	public function all_staff()
	{
		return view('backend.pages.report.employee.view');
	}
	public function all_view(Request $request)
	{
		$f=$request->t_date;
		$sql = "SELECT l.*, dpt.*, d.*, f.*, s.* FROM locations l, departments dpt, designations d, staff_files f, staff s, (Select staff_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  staff_files  where execution_date<='".$f."' group by staff_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.staff_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
		$data['staffs']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, guard_files f, guards s, (Select guard_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  guard_files  where execution_date<='".$f."' group by guard_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.guard_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['guards']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, cleaner_files f, cleaners s, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$f."' group by cleaner_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.cleaner_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['cleaners']=DB::select($sql);
			
		return view('backend.pages.report.employee.view',$data);
	}
	public function all_pdf(Request $request)
	{
		$f=$request->t_date;
		$data['t_date']=$request->t_date;
		
		$sql = "SELECT l.*, dpt.*, d.*, f.*, s.* FROM locations l, departments dpt, designations d, staff_files f, staff s, (Select staff_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  staff_files  where execution_date<='".$f."' group by staff_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.staff_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
		$data['staffs']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, guard_files f, guards s, (Select guard_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  guard_files  where execution_date<='".$f."' group by guard_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.guard_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['guards']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, cleaner_files f, cleaners s, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$f."' group by cleaner_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.cleaner_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['cleaners']=DB::select($sql);
			
		//return view('backend.pages.report.employee.pdf.all_pdf',$data);
		$pdf = PDF::loadView('backend.pages.report.employee.pdf.all_pdf',$data);
		return $pdf->stream('all_staff.pdf');
	}
	public function salary_pdf(Request $request)
	{
		$f=$request->t_date;
		$f_date=date("Y-m-01", strtotime($request->t_date)); // For First Day of month
		$t_date=date("Y-m-t", strtotime($request->t_date)); // For Last Day
		$data['t_date']=$request->t_date;
		
		$sql = "SELECT l.*, dpt.*, d.*, f.*, s.* FROM locations l, departments dpt, designations d, staff_files f, staff s, (Select staff_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  staff_files  where execution_date<='".$f."' group by staff_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.staff_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['staffs']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, staff_files f, staff s WHERE f.staff_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND (f.execution_date BETWEEN '".$f_date."' AND '".$t_date."' AND f.type='Released') AND f.execution_date!='".$f_date."' order by s.id ASC ";
		$data['release_staffs']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, guard_files f, guards s, (Select guard_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  guard_files  where execution_date<='".$f."' group by guard_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.guard_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['guards']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, guard_files f, guards s WHERE f.guard_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND (f.execution_date BETWEEN '".$f_date."' AND '".$t_date."' AND f.type='Released') AND f.execution_date!='".$f_date."' order by s.id ASC ";
		$data['release_guards']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, cleaner_files f, cleaners s, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$f."' group by cleaner_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.cleaner_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['cleaners']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, cleaner_files f, cleaners s WHERE f.cleaner_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND (f.execution_date BETWEEN '".$f_date."' AND '".$t_date."' AND f.type='Released') AND f.execution_date!='".$f_date."' order by s.id ASC ";
		$data['release_cleaners']=DB::select($sql);
			
		$pdf = PDF::loadView('backend.pages.report.employee.pdf.salary_pdf_1',$data);
		return $pdf->stream('salary_staff.pdf');
	}
	public function salary_voucher_pdf(Request $request)
	{
		$f=$request->t_date;
		$data['t_date']=$request->t_date;
		
		$sql = "SELECT l.*, dpt.*, d.*, f.*, s.* FROM locations l, departments dpt, designations d, staff_files f, staff s, (Select staff_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  staff_files  where execution_date<='".$f."' group by staff_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.staff_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
		$data['staffs']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, guard_files f, guards s, (Select guard_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  guard_files  where execution_date<='".$f."' group by guard_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.guard_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['guards']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, cleaner_files f, cleaners s, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$f."' group by cleaner_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.cleaner_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['cleaners']=DB::select($sql);
			
		$data['f_date']=$request->t_date;
		$pdf = PDF::loadView('backend.pages.report.employee.pdf.salary_voucher_1_pdf',$data);
		return $pdf->stream('salary_staff.pdf');
	}
	
	
	public function bonus_pdf(Request $request)
	{
		$f=$request->t_date;
		$data['t_date']=$request->t_date;
		$data['bonus_name']=$request->bonus_name;
		$t=date("Y-m-d", strtotime($f. ' - 2 month'));
		
		$sql = "SELECT l.*, dpt.*, d.*, f.*, s.* FROM locations l, departments dpt, designations d, staff_files f, staff s, (Select staff_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  staff_files  where execution_date<='".$f."' group by staff_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.staff_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
		$data['staffs']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, guard_files f, guards s, (Select guard_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  guard_files  where execution_date<='".$f."' group by guard_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.guard_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['guards']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, cleaner_files f, cleaners s, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$f."' group by cleaner_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.cleaner_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND s.joining_date<='".$t."' AND f.type!='Released' order by s.id ASC ";
		$data['cleaners']=DB::select($sql);
			
		$pdf = PDF::loadView('backend.pages.report.employee.pdf.bonus_pdf',$data);
		return $pdf->stream('salary_staff.pdf');
	}
	
	public function bonus_voucher_pdf(Request $request)
	{
		$f=$request->t_date;
		$data['t_date']=$request->t_date;
		
		$sql = "SELECT l.*, dpt.*, d.*, f.*, s.* FROM locations l, departments dpt, designations d, staff_files f, staff s, (Select staff_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  staff_files  where execution_date<='".$f."' group by staff_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.staff_id=s.id AND f.designation_id=d.id AND f.department_id=dpt.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		
		$data['staffs']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, guard_files f, guards s, (Select guard_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  guard_files  where execution_date<='".$f."' group by guard_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.guard_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['guards']=DB::select($sql);
		
		$sql = "SELECT l.*, d.*, f.*, s.* FROM locations l, designations d, cleaner_files f, cleaners s, (Select cleaner_id, MAX(id) as maxid, MAX(execution_date)as maxdate from  cleaner_files  where execution_date<='".$f."' group by cleaner_id)g WHERE f.id=g.maxid AND f.execution_date=g.maxdate AND f.cleaner_id=s.id AND f.designation_id=d.id AND f.location_id=l.id AND f.execution_date<='".$f."' AND f.type!='Released' order by s.id ASC ";
		$data['cleaners']=DB::select($sql);
			
		$pdf = PDF::loadView('backend.pages.report.employee.pdf.bonus_voucher_pdf',$data);
		return $pdf->stream('salary_staff.pdf');
	}
}
