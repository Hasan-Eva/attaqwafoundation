@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Leave File - Staff <button class="small float-right btn btn-warning btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-plus-circle"></i> Add New </button>
			  <button class="small float-right btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#registerModal"><i class="fa fa-list"></i>  Register</button>
			  <button class="small float-right btn btn-warning btn-sm mr-1" data-toggle="modal" data-target="#applicationModal"><i class="fa fa-list"></i>  Application</button></h4>
			  
			<!-- Ledger View Modal -->
					<div class="modal fade" id="addModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-ml" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Leave Input Form( Staff )</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="search_form" action="{{ route('leave.staff.store') }}" method="POST" id="editForm">
							@csrf
						  <div class="modal-body">
							<div class="col-sm-8 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label"> Name:</label>
									<select class="form-control select2" name="emp_id" style="width: 100%;" required>
										<option value="">Select Name</option>
										<?php 
											use App\Models\Staff;
											$names = Staff::get(); 
										?>
										@foreach($names as $row)
										<option value="{{ $row->id }} ">{{ $row->name }}</option>
										@endforeach
									 </select>
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Leave Type:</label>
									<select class="form-control select2" name="leave_type_id" style="width: 100%;" required>
										<option value="">Select Type</option>
										@foreach($types as $row)
										<option value="{{ $row->id }} ">{{ $row->leave_name }}</option>
										@endforeach
									 </select>
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">From Date:</label>
									<input type="date" name="f_date" class="form-control" id="f_date" required >
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">To Date:</label>
									<input type="date" name="t_date" class="form-control" id="t_date" required >
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Leave Day/s:</label>
									<input type="text" name="days" class="form-control" id="days" required >
								</div>
							</div>
							<div class="col-sm-8 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Remarks:</label>
									<input type="text" name="remarks" class="form-control" id="remarks" >
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Purpose:</label>
									<select class="form-control select2" name="leave_purpose_id" style="width: 100%;" required>
										<option value="">Select Type</option>
										@foreach($leave_purposes as $row)
										<option value="{{ $row->id }} ">{{ $row->purpose }}</option>
										@endforeach
									 </select>
								</div>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary btn-sm" onClick="return confirm('Are you sure, you want to Save the Data?');">Submit</button>
						  </div>
						  </form>
						</div>
					  </div>
					</div>
			<!-- End Add View Modal -->
			<!-- Register View Modal -->
					<div class="modal fade" id="registerModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-ml" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Leave Register( Staff )</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="search_form" action="{{ route('leave.staff.register') }}" method="POST" id="editForm" target="_blank">
							@csrf
						  <div class="modal-body">
							
							<div class="col-sm-6 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">From Date:</label>
									<input type="date" name="f_date" class="form-control" id="f_date" required >
								</div>
							</div>
							<div class="col-sm-6 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">To Date:</label>
									<input type="date" name="t_date" class="form-control" id="t_date" required >
								</div>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary btn-sm" onClick="return confirm('Are you sure, you want to Save the Data?');">Submit</button>
						  </div>
						  </form>
						</div>
					  </div>
					</div>
			<!-- End Register  Modal -->
			<!-- Application Modal -->
					<div class="modal fade" id="applicationModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-ml" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Leave Application Form( Staff )</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="search_form" action="{{ route('leave.staff.application') }}" method="POST" id="editForm" target="_blank">
							@csrf
						  <div class="modal-body">
							<div class="col-sm-8 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label"> Name:</label>
									<select class="form-control select2" name="emp_id" style="width: 100%;" required>
										<option value="">Select Name</option>
										@foreach($names as $row)
										<option value="{{ $row->id }} ">{{ $row->name }}</option>
										@endforeach
									 </select>
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Leave Type:</label>
									<select class="form-control select2" name="leave_type_id" style="width: 100%;" required>
										<option value="">Select Type</option>
										@foreach($types as $row)
										<option value="{{ $row->id }} ">{{ $row->leave_name }}</option>
										@endforeach
									 </select>
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">From Date:</label>
									<input type="date" name="f_date" class="form-control" id="f_date_a" required >
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">To Date:</label>
									<input type="date" name="t_date" class="form-control" id="t_date_a" required >
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Leave Day/s:</label>
									<input type="text" name="days" class="form-control" id="days_a" required >
								</div>
							</div>
							<div class="col-sm-8 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Remarks:</label>
									<input type="text" name="remarks" class="form-control" id="remarks" >
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Purpose:</label>
									<select class="form-control select2" name="leave_purpose_id" style="width: 100%;" required>
										<option value="">Select Type</option>
										@foreach($leave_purposes as $row)
										<option value="{{ $row->id }} ">{{ $row->purpose }}</option>
										@endforeach
									 </select>
								</div>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary btn-sm" onClick="return confirm('Are you sure, you want to Save the Data?');">Submit</button>
						  </div>
						  </form>
						</div>
					  </div>
					</div>
			<!-- End Application Modal -->
									
			</div>
              <!-- /.card-header -->
              <div class="card-body">
               	<table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
                  <thead>
					  <tr>
						<th width="5%">SL</th>
						<th width="20%">Name</th>
						<th width="5%">Image</th>
						<th width="10%">Designation </th>
						<th width="10%">Type </th>
						<th width="10%">From </th>
						<th width="10%">To </th>
						<th width="5%">Days </th>
						<th width="10%">Remarks </th>
						<th width="10%">Action</th>
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



<!-- Edit Modal -->
<!-- Edit 30.9.21 Modal yajra datatable-->
<div class="modal fade" id="myModal" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog cascading-modal modal-avatar modal-xl" role="document">
    <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
				<h5 class="modal-title btn btn-warning" id="exampleModalLabel">Staff Personal File  </h5>
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
			ajax: "{{ route('leave.staff.view') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'ename', name: 'ename'},
				{data: 'image', name: 'image'},
				{data: 'designation_name', name: 'designation_name'},
				{data: 'leave_name', name: 'leave_name'},
				{data: 'f_date', name: 'f_date'},
				{data: 't_date', name: 't_date'},
				{data: 'days', name: 'days'},
				{data: 'remarks', name: 'remarks'},
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
			$.get("editstaff/"+id, function(data){
				 $('#modal_body').html(data);
			});
			
		});
	});
</script>
<!-- End Edit subcategory with Ajax -->
<!-- Start PF with Ajax -->
<script type="text/javascript">
	$(function(){
		$(document).on('click','.pfi',function(){
			var id = $(this).data('id');
			//alert(id);
			$.get("pfstaff/"+id, function(data){
				 $('#modal_body').html(data);
			});
			
		});
	});
</script>
<!-- End Edit subcategory with Ajax -->
<script>
$(document).ready(function(){
	 $("#f_date, #t_date").change(function(){
	 	var f_date =  $("#f_date").val();
		var t_date =  $("#t_date").val();
		var diff = Math.floor((Date.parse(t_date) - Date.parse(f_date)) / 86400000) +1;
		$('#days').val(diff);
	  });
  });
</script>
<script>
$(document).ready(function(){
	 $("#f_date_a, #t_date_a").change(function(){
	 	var f_date =  $("#f_date_a").val();
		var t_date =  $("#t_date_a").val();
		var diff = Math.floor((Date.parse(t_date) - Date.parse(f_date)) / 86400000) +1;
		$('#days_a').val(diff);
	  });
  });
</script>
</html>
