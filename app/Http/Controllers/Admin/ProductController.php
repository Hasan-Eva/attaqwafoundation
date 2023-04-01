<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Toastr;
use App\Models\Stock;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Color;
use App\Models\Size;
use App\Models\Gender;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Image;

class ProductController extends Controller
{
   public function index(Request $request)
    {
		 if ($request->ajax()) {
		 	
			$sql = "SELECT a.*, a.id as aid, b.*, c.*, e.* FROM products a, categories b, subcategories c, units e WHERE a.category_id=b.id AND a.subcategory_id=c.id AND a.unit_id=e.id order by a.id DESC ";
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<button type="button" class="btn btn-success btn-xs show" id="getDeleteData" data-id="'.$data->aid.'" data-toggle="modal" data-target="#ShowModal">View</button>
					<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->aid.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		$data['products'] = Product::get();
		$data['categories'] = Category::get();
		$data['subcategories'] = Subcategory::get();
		$data['brands'] = Brand::get();
		$data['units'] = Unit::get();
		$data['colors'] = Color::get();
		$data['sizes'] = Size::get();
		$data['genders'] = Gender::get();
		return view('backend.pages.primary_add.product.view',$data);
    }
	
	public function store(Request $request)
    {
		$request->validate([
			'product_name'=>'required|unique:products,product_name',
			'purchase_price'=>'required',
		]);
		$data = new Product();
			$data->product_name = $request->product_name;
			$data->category_id = $request->category_id;
			$data->subcategory_id = $request->subcategory_id;
			$data->purchase_price = $request->purchase_price;
			$data->unit_id = $request->unit_id;
			$data->save();
			$product_id=$data->id;
			
			// integration
			$stock = Stock::Where ('product_id', $product_id)
						->Where ('brand_id', $request->brand_id)
						->Where ('color_id', $request->color_id)
						->Where ('size_id', $request->size_id)->get();
			$sl=0;
			foreach($stock as $data)
				{ $sl+=$data->id; }
		if($sl>0){
			Toastr::success('Sorry !! Product is exsits !!', 'Title', ["positionClass" => "toast-top-right"]);
			return back();
		}
		else 
		{
		$brands=$request->brand_id;
		$colors=$request->color_id;
		$sizes=$request->size_id;
		if($sl==0){
			if(!empty($colors)){
			  foreach($sizes as $size){
				 foreach($colors as $color){
					 foreach($brands as $brand){
						$stock = Stock::Where ('product_id', $product_id)
							->Where ('brand_id', $brand)
							->Where ('color_id', $color)
							->Where ('size_id', $size)->get();
						$sls=0;
						foreach($stock as $data)
							{ $sls+=$data->id; }
						
						if($sls==0){
						$data = new Stock;
						$data->product_id = $product_id;
						$data->brand_id = $brand;
						$data->color_id = $color;
						$data->size_id = $size;	
						$data->balance = 0;	
						$data->cost_of_fund = 0;	
						$data->save();
						}
					 }
				 }
			   }
			  }
			}
		}
			
		Toastr::success($request->product_name. ' saved successfuly !!', 'Title', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
	}
	/*
		* Edit Data With Ajax 
	*/
	public function show(Request $request)
    {
		$id = $request->id;
		$data['stocks'] = Stock::where('product_id',$id)->orderBy('color_id','asc')->get();
		
		return view('backend.pages.primary_add.product.show',$data);
    }
	public function editproduct(Request $request)
    {
		$id = $request->id;
		
		$product = DB::table('products')->where('id',$id)->first();
		$data['category'] = DB::table('categories')->where('id',$product->category_id)->first();
		$data['subcategory'] = DB::table('subcategories')->where('id',$product->subcategory_id)->first();
		$data['unit'] = DB::table('units')->where('id',$product->unit_id)->first();
		$data['product'] = DB::table('products')->where('id',$id)->first();
		$data['categories'] = DB::table('categories')->get();
		$data['subcategories'] = DB::table('subcategories')->where('category_id',$product->category_id)->get();
		
		$data['brands'] = DB::table('brands')->get();
		$data['units'] = DB::table('units')->get();
		$data['genders'] = DB::table('genders')->get();
		
		return view('backend.pages.primary_add.product.edit',$data);
    }
	/*
	public function editproduct(Request $request)
    {
		$id = $request->id;
		
		$product = DB::table('products')->where('id',$id)->first();
		$data['category'] = DB::table('categories')->where('id',$product->category_id)->first();
		$data['subcategory'] = DB::table('subcategories')->where('id',$product->subcategory_id)->first();
		$data['brand'] = DB::table('brands')->where('id',$product->brand_id)->first();
		$data['unit'] = DB::table('units')->where('id',$product->unit_id)->first();
		$data['gender'] = DB::table('genders')->where('id',$product->gender_id)->first();
		$data['product'] = DB::table('products')->where('id',$id)->first();
		$data['categories'] = DB::table('categories')->get();
		$data['subcategories'] = DB::table('subcategories')->where('category_id',$product->category_id)->get();
		
		$data['brands'] = DB::table('brands')->get();
		$data['units'] = DB::table('units')->get();
		$data['genders'] = DB::table('genders')->get();
		
		return view('backend.pages.primary_add.product.edit',$data);
    }
	*/
	public function update(Request $request)
	{
		$id=$request->id;
		$data = Product::find($id);
		$data->product_name  = $request->product_name;
		$data->category_id  = $request->category_id;
		$data->subcategory_id  = $request->subcategory_id;
		$data->purchase_price  = $request->purchase_price;
		$data->unit_id  = $request->unit_id;
		$data->save();
		
		return redirect()->back();
	}
	
	public function integration(Request $request)
	{
		if ($request->ajax()) {
		 	
			$sql = "SELECT a.*, a.id as aid, b.*, c.*, d.* FROM stocks a, products b, colors c, sizes d WHERE a.product_id=b.id AND a.color_id=c.id AND a.size_id=d.id order by b.id, c.color_name, d.size_name ASC ";
			$data=DB::select($sql);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '
					<button type="button" class="btn btn-success btn-xs edit" id="getEditArticleData" data-id="'.$data->aid.'" data-toggle="modal" data-target="#EditModal">Edit</button> 
					';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        	}
		
		$data['products'] = Product::get();
		$data['colors'] = Color::orderBy('color_name','asc')->get();
		$data['sizes'] = Size::orderBy('size_name','asc')->get();
		
		return view('backend.pages.primary_add.product.integration.view',$data);
    }
	public function integration_store(Request $request)
    {
		
		$stock = Stock::Where ('product_id', $request->product_id)
						->Where ('color_id', $request->color_id)
						->Where ('size_id', $request->size_id)->get();
			$sl=0;
			foreach($stock as $data)
				{ $sl+=$data->id; }
		if($sl>0){
			Toastr::success('Sorry!! Product is already exsits !!', '', ["positionClass" => "toast-top-right"]);
			return back();
		}
		else 
		{
		$colors=$request->color_id;
		$sizes=$request->size_id;
		if($sl==0){
			if(!empty($colors)){
			  foreach($sizes as $size){
				 foreach($colors as $color){
				 	$stock = Stock::Where ('product_id', $request->product_id)
						->Where ('color_id', $color)
						->Where ('size_id', $size)->get();
					$sls=0;
					foreach($stock as $data)
						{ $sls+=$data->id; }
					
					if($sls==0){
					$data = new Stock;
					$data->product_id = $request->product_id;
					$data->color_id = $color;
					$data->size_id = $size;	
					$data->balance = 0;
					$data->cost_of_fund = 0;
					$data->save();
					}
				 }
			  }
			}
		}
			
		Toastr::success('Saved Successfully !!', '', ["positionClass" => "toast-top-right"]);
	   	return redirect()->back();
		}
	}
	public function edit(Request $request)
    {
		$id = $request->id;
		$data['stock'] = Stock::where('id',$id)->first();
		$data['colors'] = Color::get();
		$data['sizes'] = Size::get();
		
		return view('backend.pages.primary_add.product.integration.edit',$data);
    }
	public function integretion_update(Request $request)
	{
		$stock = Stock::Where ('product_id', $request->product_id)
						->Where ('color_id', $request->color_id)
						->Where ('size_id', $request->size_id)->get();
			$sl=0;
			foreach($stock as $data)
				{ $sl+=$data->id; }
		if($sl>0){
			Toastr::success('Sorry!! Product is already exsits !!', '', ["positionClass" => "toast-top-right"]);
			return redirect()->back();
		}
		else 
		{
		$id=$request->id;
		$data = Stock::find($id);
		$data->color_id  = $request->color_id;
		$data->size_id  = $request->size_id;
		$data->save();
		
		Toastr::success('Product updated successfuly !!', '', ["positionClass" => "toast-top-right"]);
		return redirect()->back();
		}
	}
}
