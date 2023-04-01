<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Ac_head;
use App\Models\Occupant;
use App\Models\Occupant_location;
use App\Models\Location;
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

class OccupantController extends Controller
{
    public function occupant_view()
    {
		$data['occupants'] = Occupant_location::orderBy('id', 'asc')->get();
		
		$data['locations'] = Location::orderBy('id', 'asc')->get();
		
		//return $data; 
		return view('frontend.pages.occupant.view',$data);
    }
}
