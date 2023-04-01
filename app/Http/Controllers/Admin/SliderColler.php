<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Post;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Image;

class SliderColler extends Controller
{
    public function index(Request $request)
    {
		 if ($request->ajax()) {
			$data=Post::get();
            return DataTables::of($data)
                ->addIndexColumn()
				->addColumn('image', function ($data) { 
            		$url= asset('public/images/post/'.$data->id.''.$data->extention);
            		return '<img src='.$url.' border="0" width="50" class="rounded-borders" align="center" />';
        		})
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs" id="getEditArticleData" data-id="'.$data->id.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					<!--
					<button type="button" class="btn btn-success btn-xs" id="getDeleteData" data-id="'.$data->id.'" data-toggle="modal" data-target="#deleteModal">Delete</button>
					-->
					';
                    return $actionBtn;
                })
                ->rawColumns(['image','action'])
                ->make(true);
        	}
		
		$data['posts'] = Post::get();
		return view('backend.slider.view',$data);
    }
	public function store(Request $request)
    {
		/*
		$request->validate([
			'name'=>'required|unique:categories,name'
		]);
		*/
		
		$data = new Post();
			$data->head  = $request->head ;
			$data->description = $request->description;
			// Image Save
				if($request->hasFile('image')){
					$i=1;
					foreach($request->image as $image){
						//$image = $request->file('image');
						//$img = time()+$i . '.' . $image->getClientOriginalExtension();
						$img = $data->id . '.' . $image->getClientOriginalExtension();
						
						$data->extention = $img;
						
						$i++;
					}
				}
			$data->user_id = Auth::user()->id;
			$data->save();
			$id = $data->id;
			// Image Save
				if($request->hasFile('image')){
					$i=1;
					foreach($request->image as $image){
						//$image = $request->file('image');
						//$img = time()+$i . '.' . $image->getClientOriginalExtension();
						$img = $data->id . '.' . $image->getClientOriginalExtension();
						$location = public_path('images/post/' .$img);
						Image::make($image)->save($location)->resize(200, 300);;
						
						//$product_image = new ProductImage;
						//$product_image->stock_id	= $stock->id;
						$data->extention = $img;
						
						$i++;
					}
				}
								
		Toastr::success($request->name. ' saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
}
