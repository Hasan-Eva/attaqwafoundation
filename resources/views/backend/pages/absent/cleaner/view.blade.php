@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Absent List (Cleaner)<button class="small float-right btn btn-warning btn-sm" data-toggle="modal" data-target="#advanceModal"><i class="fa fa-plus-circle"></i> Add New</button></h4>						
			  </div>
			  
			  <!-- Ledger View Modal -->
					<div class="modal fade" id="advanceModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-ml" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Absent Input Form( Cleaners )</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="search_form" action="{{ route('absent.cleaner.store') }}" method="POST" id="editForm">
							@csrf
						  <div class="modal-body">
							<div class="col-sm-6 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Absent Date:</label>
									<input type="date" name="f_date" class="form-control" id="f_date" required >
								</div>
							</div>
							<div class="col-sm-6 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Total Absent:</label>
									<input type="number" name="total_absent" class="form-control" id="total_absent" required >
								</div>
							</div>
							<div class="col-sm-12 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label"> Name:</label>
									<select class="form-control select2" name="emp_id" style="width: 100%;" required>
										<option value="">Select Cleaner Name</option>
										<?php 
											use App\Models\Cleaner;
											use App\Models\Absent_cleaner;
											$names = Cleaner::get(); 
											$absents = Absent_cleaner::get(); 
										?>
										@foreach($names as $row)
										<option value="{{ $row->id }} ">{{ $row->name }}</option>
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
					<!-- End Ledger View Modal -->
			  
              <!-- /.card-header -->
              <div class="card-body">
               	<table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
                  <thead>
					  <tr>
						<th width="5%">SL</th>
						<th width="20%">Name</th>
						<th width="10%">Image</th>
						<th width="15%">Date of Joining </th>
						<th width="10%">Contact </th>
						<th width="15%">Month </th>
						<th width="20%">Absent Day(s) </th>
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
			ajax: "{{ route('absent.cleaner.view') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'image', name: 'image'},
				{data: 'joining_date', name: 'joining_date'},
				{data: 'phone_1', name: 'phone_1'},
				{data: 'date', name: 'date'},
				{data: 'total_absent', name: 'total_absent'},
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
