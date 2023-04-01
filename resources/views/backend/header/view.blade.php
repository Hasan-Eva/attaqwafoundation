@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Header Information </h4>
									
			</div>
              <!-- /.card-header -->
              <div class="card-body">
               	<table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
                  <thead>
					  <tr>
						<th width="5%">SL</th>
						<th width="25%">Company Name</th>
						<th width="30%">Address</th>
						<th width="15%">Email</th>
						<th width="15%">Phone</th>
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


<!-- Edit Client Modal -->
<?php
use App\Models\Company_info;
$company_info = Company_info::where('id',1)->first();
?>
<div class="modal" id="EditModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
			<form id="search_form" action="{{ route('header.update') }}" method="POST" id="editForm" enctype="multipart/form-data">
			@csrf
            <div class="modal-header">
                <h4 class="modal-title">Edit Company Information </h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
					<small>Company Name:</small>
					<input type="hidden" name="id" value="{{ $company_info->id }}" >
					<input type="text" name="company_name" class="form-control" id="company_name" placeholder="Input" value="{{ $company_info->company_name }}" required>
					<span class="text-danger">@error('head'){{$message}}@enderror</span>
				</div>
                <div class="form-group">
					<small>Company Address:</small>
					<input type="text" name="address" class="form-control" id="address" placeholder="Input address" value="{{ $company_info->address }}" required>
					<span class="text-danger">@error('head'){{$message}}@enderror</span>
				</div>
				<div class="form-group">
					<small>Company Email:</small>
					<input type="text" name="email" class="form-control" id="email" placeholder="Input email" value="{{ $company_info->email }}" required>
					<span class="text-danger">@error('head'){{$message}}@enderror</span>
				</div>
				<div class="form-group">
					<small>Company Phone:</small>
					<input type="text" name="phone" class="form-control" id="phone" placeholder="Input New Category Name" value="{{ $company_info->phone }}" required>
					<span class="text-danger">@error('phone'){{$message}}@enderror</span>
				</div>
                <div id="EditArticleModalBody">
                     
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="SubmitEditArticleForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
			</form>
        </div>
    </div>
</div>
<!-- / Edit Modal -->


<!-- Sweet Alert for Update Data -->
<script type="text/javascript">
 
     $('.show_confirm').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to update this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
  
</script>
<!-- / Sweet Alert -->
<!-- Sweet Alert for Delete Data -->
<script type="text/javascript">
 
     $('#show_delete').click(function(event) {
          var form =  $(this).closest("form");
          var name = $(this).data("name");
          event.preventDefault();
          swal({
              title: `Are you sure you want to delete this record?`,
              text: "If you delete this, it will be gone forever.",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              form.submit();
            }
          });
      });
  
</script>
<!-- / Sweet Alert for Delete Data -->


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
        ajax: "{{ route('header.view') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'company_name', name: 'company_name'},
			{data: 'address', name: 'address'},
			{data: 'email', name: 'email'},
			{data: 'phone', name: 'phone'},
			{
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
	
<!-- Get single article in EditModel -->
        $('.modelClose').on('click', function(){
            $('#EditModal').hide();
        });
        var id;
        $('body').on('click', '#getEditArticleData', function(e) {
            // e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
           var id = $(this).data('id');
            $.ajax({
                url:"{{route('header.edit')}}",
                method: 'GET',
                data: {
                    id:id
                 },
                success: function(result) {
                    console.log(result);
                    $('#EditArticleModalBody').html(result.html);
                    $('#EditModal').show();
                }
            });
        });
	  });
 </script>
<!--/ Edit single Data in EditModel -->
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
				url:"{{route('brand.update')}}",
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
						alert('Data Updated Successfuly');
						//window.confirm("sometext");
					}, 100);
				}
			});
		});
	});
</script>
<!-- / Update single Data in EditModel -->


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
				url:"{{route('brand.delete')}}",
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
