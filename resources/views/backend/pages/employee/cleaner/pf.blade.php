@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Personal File (Cleaner) <button class="small float-right btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> Add New</button></h4>
									
			</div>
              <!-- /.card-header -->
              <div class="card-body">
               	<table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
                  <thead>
					  <tr>
						<th width="5%">SL</th>
						<th width="20%">Name</th>
						<th width="15%">Designation </th>
						<th width="15%">Department </th>
						<th width="10%">Posting </th>
						<th width="15%">Shift </th>
						<th width="8%">Salary </th>
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



<!-- Edit Modal -->
<!-- Edit 30.9.21 Modal yajra datatable-->
<div class="modal fade" id="PFModal" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel" aria-hidden="true" style="overflow:hidden;">
  <div class="modal-dialog cascading-modal modal-avatar modal-xl" role="document">
    <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
				<h5 class="modal-title btn btn-warning" id="exampleModalLabel">Cleaner Personal File  </h5>
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
			ajax: "{{ route('personal_file.cleaner.view') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'name', name: 'name'},
				{data: 'designation_name', name: 'designation_name'},
				{data: 'department_name', name: 'department_name'},
				{data: 'location_name', name: 'location_name'},
				{data: 'period', name: 'period'},
				{data: 'total_salary', name: 'total_salary'},
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

<!-- Start PF with Ajax -->
<script type="text/javascript">
	$(function(){
		$(document).on('click','.pfi',function(){
			var id = $(this).data('id');
			//alert(id);
			$.get("pfcleaner/"+id, function(data){
				 $('#modal_body').html(data);
			});
			
		});
	});
</script>
<!-- End Edit subcategory with Ajax -->

</html>
