<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Brand;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;

class BrandController extends Controller
{
    public function index(Request $request)
    {
		 if ($request->ajax()) {
		 	
			$sql = "SELECT * FROM brands order by id DESC ";
			$data=DB::select($sql);
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
		
		$data['brands'] = Brand::get();
		return view('backend.pages.primary_add.brand.view',$data);
    }
	
	public function store(Request $request)
    {
		$request->validate([
			'brand_name'=>'required|unique:brands,brand_name'
		]);
		$saving = new Brand();
			$saving->brand_name = $request->brand_name;
			$saving->save();
			
		Toastr::success($request->brand_name. ' saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
	/*
		* Edit Data With Ajax 
	*/
	
	public function edit(Request $request)
    {
		$id = $request->id;
		
		$data = DB::table('brands')->where('id',$id)->first();
		
        $html = '<div class="col-sm-12">
					<div class="form-group">
                    	<small>Category Name:</small>
						<input type="hidden" name="id" id="cl_id" value="'.$data->id.'" />
                    	<input type="text" class="form-control" name="name" id="name_id" value="'.$data->brand_name.'" />
                	</div>
				</div>';

        return response()->json(['html'=>$html]);
    }
	public function update_client(Request $request)
	{
		$data = Brand::find($request->id);
		$data->brand_name  = $request->name;
		$data->save();
			
		return response()->json(['success' => 'Data is successfully updated']);
	}
}
