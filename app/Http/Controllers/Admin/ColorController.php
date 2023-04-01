<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Color;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;

class ColorController extends Controller
{
   public function index(Request $request)
    {
		 if ($request->ajax()) {
		 	
			$sql = "SELECT * FROM colors order by id DESC ";
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
		$data['colors'] = Color::get();
		return view('backend.pages.primary_add.color.view',$data);
    }
	
	public function store(Request $request)
    {
		$request->validate([
			'color_name'=>'required|unique:colors,color_name'
		]);
		$saving = new Color();
			$saving->color_name = $request->color_name;
			$saving->save();
			
		Toastr::success($request->color_name. ' saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
	/*
		* Edit Data With Ajax 
	*/
	
	public function edit(Request $request)
    {
		$id = $request->id;
		
		$data = DB::table('colors')->where('id',$id)->first();
		
        $html = '<div class="col-sm-12">
					<div class="form-group">
                    	<small>Category Name:</small>
						<input type="hidden" name="id" id="cl_id" value="'.$data->id.'" />
                    	<input type="text" class="form-control" name="name" id="name_id" value="'.$data->color_name.'" />
                	</div>
				</div>';

        return response()->json(['html'=>$html]);
    }
	public function update(Request $request)
	{
		$data = Color::find($request->id);
		$data->color_name  = $request->name;
		$data->save();
			
		return response()->json(['success' => 'Data is successfully updated']);
	}
}
