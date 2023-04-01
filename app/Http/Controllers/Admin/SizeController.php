<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Size;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;

class SizeController extends Controller
{
   public function index(Request $request)
    {
		 if ($request->ajax()) {
		 	
			$sql = "SELECT * FROM sizes order by id DESC ";
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
		$data['sizes'] = Size::get();
		return view('backend.pages.primary_add.size.view',$data);
    }
	
	public function store(Request $request)
    {
		$request->validate([
			'size_name'=>'required|unique:sizes,size_name'
		]);
		$saving = new Size();
			$saving->size_name = $request->size_name;
			$saving->save();
			
		return redirect()->back();
	}
	/*
		* Edit Data With Ajax 
	*/
	
	public function edit(Request $request)
    {
		$id = $request->id;
		
		$data = DB::table('sizes')->where('id',$id)->first();
		
        $html = '<div class="col-sm-12">
					<div class="form-group">
                    	<small>Category Name:</small>
						<input type="hidden" name="id" id="cl_id" value="'.$data->id.'" />
                    	<input type="text" class="form-control" name="name" id="name_id" value="'.$data->size_name.'" />
                	</div>
				</div>';

        return response()->json(['html'=>$html]);
    }
	public function update(Request $request)
	{
		$data = Size::find($request->id);
		$data->size_name  = $request->name;
		$data->save();
			
		return response()->json(['success' => 'Data is successfully updated']);
	}
}
