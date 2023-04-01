@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Sub-category List <button class="small float-right btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> Add New</button></h4>
									
			</div>
              <!-- /.card-header -->
              <div class="card-body">
               	<table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
                  <thead>
					  <tr>
						<th width="5%">SL</th>
						<th width="55%">Sub-category Name</th>
						<th width="30%">Category Name</th>
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


<!-- Modal for add new -->
<div class="modal fade" id="myModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-ml" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Sub Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	   <form id="search_form" action="{{ route('subcategory.store') }}" method="POST" id="editForm">
		@csrf
      <div class="modal-body">
	  	<div class="col-sm-12 float-left">
			<div class="form-group">
				<small>Sub Category Name:</small>
				<input type="text" name="subcategory_name" class="form-control" id="subcategory_name" placeholder="Input New Sub-category Name" value="" required>
				<span class="text-danger">@error('subcategory_name'){{$message}}@enderror</span>
			</div>
			<div class="form-group">
				<small>Category Name:</small>
				<select class="form-control select2" name="category_id" style="width: 100%;" required>
					<option value="">Select Category</option>
                    @foreach($categories as $row)
					<option value="{{ $row->id }}">{{ $row->category_name }}</option>
                    @endforeach
                 </select>
				 <span class="text-danger">@error('category_id'){{$message}}@enderror</span>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-sm" >Save Sub-category</button>
      </div>
	  </form>
    </div>
  </div>
</div>


<!-- Edit Modal -->
<!-- Edit 30.9.21 Modal yajra datatable-->
<div class="modal fade" id="EditModal" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-md" role="document">
    <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Sub Category Edit </h5>
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
			ajax: "{{ route('subcategory.view') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'subcategory_name', name: 'subcategory_name'},
				{data: 'category_name', name: 'category_name'},
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
			$.get("edit/"+id, function(data){
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
