<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Company_info;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Image;

class HeaderColler extends Controller
{
    public function index(Request $request)
    {
		 if ($request->ajax()) {
		 	
			//$sql = "SELECT * FROM brands order by id DESC ";
			//$data=DB::select($sql);
			$data=Company_info::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					<!--
					<button type="button" class="btn btn-success btn-xs" id="getDeleteData" data-id="'.$data->id.'" data-toggle="modal" data-target="#deleteModal">Delete</button>
					-->
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		
		$data['post'] = Company_info::get();
		return view('backend.header.view',$data);
    }
	public function update(Request $request)
    {
		$data = Company_info::find($request->id);
		$data->company_name  = $request->company_name;
		$data->address  = $request->address;
		$data->email  = $request->email;
		$data->phone  = $request->phone;
		$data->save();
								
		Toastr::success('Updated successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
}
