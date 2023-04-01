@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')
<style>
      .rounded-borders {
        height: 60px;
        width: 60px;
        border-color: #666 #8ebf42;
        border-image: none;
        border-radius: 10px 0 10px 0;
        border-style: solid;
        border-width: 3px;
      }
      img {
        height: 100%;
        width: 100%;
      }
</style>
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Cleaner List <button class="small float-right btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> Add New</button></h4>
									
			</div>
              <!-- /.card-header -->
              <div class="card-body">
               	<table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
                  <thead>
					  <tr>
						<th width="5%">SL</th>
						<th width="20%">Name</th>
						<th width="8%">Image</th>
						<th width="10%">Position </th>
						<th width="15%">Date of Joining </th>
						<th width="18%">Place of Posting </th>
						<th width="10%">Contact </th>
						<th width="5%">Action</th>
					  </tr>
                  </thead>
                  <tbody>
                 
				  </tbody>
				</table>
		  	</div>
	    </div>
      </div>
	</div>
  </div>


<!-- Modal -->
<div class="modal fade" id="myModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title btn btn-warning" id="exampleModalLabel">New Cleaner Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	   <form id="search_form" action="{{ route('cleaner.store') }}" method="POST" enctype="multipart/form-data">
		@csrf
      <div class="modal-body">
	  	<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Cleaner's Name:</small>
				<input type="text" name="name" class="form-control" id="name" placeholder="Name of the Client" value="" required>
			</div>
			<div class="form-group">
				<small>Mobile Number 1:</small>
				<input type="text" name="phone_1" class="form-control" id="phone_1" placeholder="017123xxxxxx"  />
			</div>
			<div class="form-group">
				<small>Present Address:</small>
				<input type="text" name="present_address" class="form-control" id="present_address" />
			</div>
			<div class="form-group">
				<small>Date of Birth:</small>
				<input type="date" name="date_of_birth" class="form-control" id="date_of_birth" value="" required/>
			</div>
			<div class="form-group">
				<small>Date of Joining:</small>
				<input type="date" name="joining_date" class="form-control" id="joining_date" value="{{date('Y-m-d')}}" />
			</div>
			<div class="form-group">
				<small>Job Type :</small>
				<select class="form-control select2" name="jobtype" style="width: 100%;" required>
                    <option value="Contactual">Contactual</option>
					<option value="Outsourceing">Outsourceing</option>
                 </select>
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Father's Name:</small>
				<input type="text" name="father_name" class="form-control" id="father_name" value="">
			</div>
			<div class="form-group">
				<small>Mobile Number 2:</small>
				<input type="text" name="phone_2" class="form-control" id="phone_2" placeholder="017123xxxxxx"  />
			</div>
			<div class="form-group">
				<small>Present Thana & District :</small>
				<select class="form-control select2" name="present_upazila" style="width: 100%;" >
                    <option value="">Thana & District</option>
                    @foreach($upazilas as $row)
					<option value="{{ $row->u_name.", ".$row->district->name }}">{{ $row->u_name }}, {{ $row->district->name }}</option>
                    @endforeach
                 </select>
			</div>
			<div class="form-group">
				<small>NID Number:</small>
				<input type="text" name="nid" class="form-control" id="nid" />
			</div>
			<div class="form-group">
				<small>Designation :</small>
				<select class="form-control select2" name="designation_id" style="width: 100%;" required>
                    @foreach($designations as $row)
					<option value="{{ $row->id }}">{{ $row->designation_name }}</option>
                    @endforeach
                 </select>
			</div>
			<div class="form-group">
				<small>Duty Shift :</small>
				<select class="form-control select2" name="shift_id" style="width: 100%;" required>
                    <option value="">Select Shift</option>
                    @foreach($shifts as $row)
					<option value="{{ $row->id }}">({{ $row->shift_name }}) {{ $row->period }}</option>
                    @endforeach
                 </select>
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Mother's Name :</small>
				<input type="text" name="mother_name" class="form-control" id="mother_name" value="">
			</div>
			<div class="form-group">
				<small>Email Address:</small>
				<input type="text" name="email" class="form-control" id="email" placeholder="017123xxxxxx"  />
			</div>
			<div class="form-group">
				<small>Parmanent Address:</small>
				<input type="text" name="permanent_address" class="form-control" id="permanent_address" />
			</div>
			<div class="form-group">
				<small>Blood Group :</small>
				<select class="form-control select2" name="blood_group" style="width: 100%;" >
					@foreach($blood_groups as $row)
					<option value="{{ $row->blood_group_name }}"> {{ $row->blood_group_name }}</option>
                    @endforeach
                 </select>
			</div>
			<div class="form-group">
				<small>Department :</small>
				<select class="form-control select2" name="department_id" style="width: 100%;" required>
                    <option value="6">Cleaning </option>
                    
                 </select>
			</div>
			<div class="form-group">
				<small>Basic Salary:</small>
				<input type="text" name="basic_salary" class="form-control" id="basic_salary" value="">
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Spouse Name:</small>
				<input type="text" name="spouse_name" class="form-control" id="spouse" value="">
			</div>
			<div class="form-group">
				<small>Emergency Contact:</small>
				<input type="text" name="emergency_contact" class="form-control" id="emergency_contact" placeholder="017123xxxxxx"  />
			</div>
			<div class="form-group">
				<small>Parmanent Thana & District :</small>
				<select class="form-control select2" name="permanent_upazila" style="width: 100%;" required>
                    <option value="">Thana & District</option>
                    @foreach($upazilas as $row)
					<option value="{{ $row->u_name.", ".$row->district->name }}">{{ $row->u_name }}, {{ $row->district->name }}</option>
                    @endforeach
                 </select>
			</div>
			<div class="form-group">
				<small>EmployImage Image :</small>
				<input class="form-control" type="file" name="image[]" >
			</div>
			<div class="form-group">
				<small>Place of Posting :</small>
				<select class="form-control select2" name="location_id" style="width: 100%;" required>
					<option value="">Select Location</option>
                    @foreach($locations as $row)
					<option value="{{ $row->id }} ">{{ $row->location_name }}</option>
                    @endforeach
                 </select>
			</div>
			<div class="form-group">
				<small>Total Salary:</small>
				<input type="text" name="total_salary" class="form-control" id="total_salary" value="">
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Save Data</button>
      </div>
	  </form>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<!-- Edit 30.9.21 Modal yajra datatable-->
<div class="modal fade" id="EditModal" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-xl" role="document">
    <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
				<h5 class="modal-title btn btn-warning" id="exampleModalLabel">Edit Cleaner's Information  </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
            <!-- Modal body -->
          	<div id="modal_body">
                     
          	</div>
      </div>
   </div>
</div>
<!-- / Edit Modal -->


</section>

@endsection

<script src="{{ asset('public/backend') }}/plugins/datatables/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
    
		$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		});
	
		var table = $('.ytable').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('cleaner.view') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'image', name: 'image'},
				{data: 'designation_name', name: 'designation_name'},
				{data: 'joining_date', name: 'joining_date'},
				{data: 'location_name', name: 'location_name'},
				{data: 'phone_1', name: 'phone_1'},
				{
					data: 'action', 
					name: 'action', 
					orderable: true, 
					searchable: true
				},
			]
		});

	});
 </script>

<!-- Start Edit subcategory with Ajax -->
<script type="text/javascript">
	$(function(){
		$(document).on('click','.edit',function(){
			
			var id = $(this).data('id');
			//alert(id);
			$.get("editcleaner/"+id, function(data){
				 $('#modal_body').html(data);
			});
			
		});
	});
</script>
<!-- End Edit subcategory with Ajax -->
<!-- Update single Data in EditModel -->
 <script type="text/javascript">
	$(function(){
		$(document).on('click','#SubmitEditArticleForm',function(){
			
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			var id = $("#cl_id").val();
			var name = $('#name_id').val();
			//alert(id);
			//$('.modal').hide();
			$.ajax({
				url:"{{route('subcategory.update')}}",
				type: 'GET',
				dataType:'JSON',
				data: {'_token':'{{ csrf_token() }}', 'foo':'bar'},
				data:{
					id:id,
					name:name,
					},
				success:function(data){
					console.log(data);
					 setTimeout(function(){
						$("#EditModal").removeClass("in");
						$(".modal-backdrop").remove();
						$("#EditModal").hide();
					 	$('.datatable').DataTable().ajax.reload();
						//alert('Data Updated Successfuly');
						//window.confirm("sometext");
					}, 100);
				}
			});
		});
	});
</script>
<!-- / Update single Data in EditModel -->
<!-- Get single data in deleteModel -->
<script>
$(document).ready(function() {
        $('.modelClose').on('click', function(){
            $('#deleteModal').hide();
        });
        var id;
        $('body').on('click', '#getDeleteData', function(e) {
            // e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
           var id = $(this).data('id');
            $.ajax({
                url:"{{route('subcategory.delete_view')}}",
                method: 'GET',
                data: {
                    id:id
                 },
                success: function(result) {
                    console.log(result);
                    $('#DeleteModalBody').html(result.html);
                    $('#deleteModal').show();
                }
            });
        });
  });
</script>

<!-- Delete single Data in DeleteModel -->
 <script type="text/javascript">
	$(function(){
		$(document).on('click','#SubmitDeleteForm',function(){
			
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			var id = $("#cl_id").val();
			//alert(id);
			//$('.modal').hide();
			$.ajax({
				url:"{{route('category.delete')}}",
				type: 'GET',
				dataType:'JSON',
				data: {'_token':'{{ csrf_token() }}', 'foo':'bar'},
				data:{
					id:id,
					},
				success:function(data){
					console.log(data);
					 setTimeout(function(){
						$("#EditArticleModal").removeClass("in");
						$(".modal-backdrop").remove();
						$("#deleteModal").hide();
					 	$('.datatable').DataTable().ajax.reload();
						//alert('Data Updated Successfuly');
					}, 100);
				}
			});
		});
	});
</script>

<!-- / Delete Data in EditModel -->
</html>
