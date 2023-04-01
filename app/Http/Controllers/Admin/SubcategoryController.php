<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Category;
use App\Models\Subcategory;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;

class SubcategoryController extends Controller
{
   public function index(Request $request)
    {
		 if ($request->ajax()) {
		 	
			$sql = "SELECT a.*, b.*, b.id as bid FROM categories a, subcategories b WHERE a.id=b.category_id order by b.id DESC ";
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->bid.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					<!--
					<button type="button" class="btn btn-success btn-xs" id="getDeleteData" data-id="'.$data->id.'" data-toggle="modal" data-target="#deleteModal">Delete</button>
					-->
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		
		$data['categories'] = Category::get();
		return view('backend.pages.primary_add.subcategory.view',$data);
    }
	
	public function store(Request $request)
    {
		$request->validate([
			'subcategory_name'=>'required|unique:subcategories,subcategory_name'
		]);
		$saving = new Subcategory();
			$saving->subcategory_name = $request->subcategory_name;
			$saving->category_id = $request->category_id;
			$saving->save();
			
		Toastr::success($request->subcategory_name. ' Sub-category saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);	
		return redirect()->back();
	}
	/*
		* Edit Data With Ajax 
	*/
	
	public function edit(Request $request)
    {
        $id = $request->id;
		$subcategory = DB::table('subcategories')->where('id',$id)->first();
		$data['category_id'] = DB::table('categories')->where('id',$subcategory->category_id)->first();
		$data['subcategory'] = DB::table('subcategories')->where('id',$id)->first();
		$data['categories'] = DB::table('categories')->get();
		
		return view('backend.pages.primary_add.subcategory.edit',$data);
	}
	public function update(Request $request){
		$id=$request->id;
		$data = Subcategory::find($id);
		$data->subcategory_name  = $request->subcategory_name;
		$data->category_id  = $request->category_id;
		$data->save();
		
		return redirect()->back();
	}
	
}
