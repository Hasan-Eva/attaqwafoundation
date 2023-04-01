<?php  
use App\Models\Post;
$posts = Post::get();
?>

@extends('frontend.layouts.master')
@section('content')
<div style="height:200px;">
   <img class="" src="{{ asset('public/frontend') }}/images/slider-main/bg5.jpg" alt="AdminLTELogo" height="100%" width="100%">
</div>
<div class="modal-body" >
	<div class="col-sm-3 float-left">
	  <select class="form-control select2" name="designation_id" style="width: 100%;" required>
		<option value="">Select Donation</option>
		<option value="0">Single Donation</option>
		<option value="1">Regular Donation</option>
	  </select>
	</div>
	<div class="col-sm-3 float-left">
	  <select class="form-control select2" name="designation_id" style="width: 100%;" required>
		<option value="">Select Donation</option>
		<option value="0">Single Donation</option>
		<option value="1">Regular Donation</option>
	  </select>
	</div>
	<div class="col-sm-3 float-left">
	  <select class="form-control select2" name="designation_id" style="width: 100%;" required>
		<option value="">Select Donation</option>
		<option value="0">Single Donation</option>
		<option value="1">Regular Donation</option>
	  </select>
	</div>
	<div class="col-sm-3 float-left">
	  <input type="button" value="Quick Donate" />
	</div>
</div>

<div class="" style="margin-top: 40px; background:black;">
	@foreach($posts as $row)
	<div class="col-sm-4 float-left ">
		<div class="col-sm-12 float-left ">
		  <img style="max-width:100%; height:250px;" src="{{ asset('public/images/post') }}/{{ $row->id }}{{ $row->extention }}" alt="AdminLTELogo" height="100%" width="100%">
		</div>
		<div class="col-sm-12 float-left text-center mt-2">
		  <h4>{{ $row->head }}</h4>
		  <p>{{ $row->description }}</p>
		  <button type="button" class="btn btn-secondary">DONATE NOW</button>
		</div>
	</div>
	@endforeach
</div>
@endsection