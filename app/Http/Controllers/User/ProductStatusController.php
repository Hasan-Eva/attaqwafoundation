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
use App\Models\Confirm_status;
use App\Models\Stock;
use App\Models\Customer;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;

class ProductStatusController extends Controller
{
    public function index(Request $request)
    {
		 if ($request->ajax()) {
		 	
			$sql = "SELECT c.*, s.*, st.*, pd.*, ps.*, cl.*, sz.*, h.*, o.*, o.id as oid, d.*, (CASE  WHEN o.shipping_address = 1 THEN c.address_1 WHEN o.shipping_address = 2 THEN c.address_2 ELSE '' END) as address, (SELECT AVG(product_status_id) FROM  customer_order_details WHERE customer_order_details.customer_order_id=o.id) as pstatus FROM customers c, customer_orders o, customer_order_details d, users h, stocks st, products pd, colors cl, sizes sz, confirm_statuses s, product_statuses ps WHERE o.customer_id=c.id AND o.id=d.customer_order_id AND d.confirm_status_id=s.id AND d.product_status_id=ps.id AND o.user_id=h.id AND d.stock_id=st.id AND st.product_id=pd.id AND st.color_id=cl.id AND st.size_id=sz.id order by o.id DESC ";
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('mergeProduct', function($row){
                	return $row->product_name.',    '.$row->color_name.'  '.$row->size_name;
           		 })
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs edit" id="getEditData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal"> Edit</button> 
					<a href="'. route('customer_order_detail.order_update', $data->id) .'" class="btn btn-danger btn-xs confirm" type="submit" style="margin-left:10px;" title="Show Cart"><i class="fa fa-edit"></i></a>
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		
		return view('frontend.pages.product.product_status');
    }
}
