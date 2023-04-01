@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')
    <body class="bg-primary">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-0">
                                    <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Integration Product <button class="small float-right btn btn-primary btn-xs" id="show"><i class="fa fa-plus-circle"></i> Add New</button></h4>
									</div>
     <div class="card-body" id="frm" style="display:none;">
      <form method="POST" action="{{ route('integration.store') }}" enctype="multipart/form-data">
      @csrf
		<div class="col-md-12" style="float:left;">
			<div class="col-md-3" style="float:left;">
				<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Product Name</label>
					<select name="product_id" id="product_id" class="form-control form-control-sm select2" required />
					<option value="">Select Product</option>
						@foreach($products as $row)
						<option value="{{ $row->id }}">{{ $row->product_name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div> 
		<div class="col-md-12 float-left">
				<div class="col-md-6 float-left md-form ml-0 mr-0">
					<label class="small mb-1" for="inputEmailAddress">Product Color</label>
					<select name="color_id[]" class="form-control form-control-sm select2" id="" multiple required>
							<option value="">Select Color</option>
							@foreach($colors as $row)
							<option value="{{ $row->id }}">{{ $row->color_name }}</option>
							@endforeach
					</select>
				</div>
				<div class="col-md-6 float-right md-form ml-0 mr-0">
				   <label class="small mb-1" for="inputEmailAddress">Product Size</label>
					<select name="size_id[]" class="form-control form-control-sm select2" id="" multiple required>
						<option value="">Select Size</option>
						@foreach($sizes as $row)
						<option value="{{ $row->id }}">{{ $row->size_name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-2 float-right md-form ml-0 mr-2 mt-2">
					<button type="submit" class="btn btn-success form-control btn-sm" >Submit</button>
				</div> 
			</div>
		</div>   							 
	</div>								
   </form>

<div class="card-body">
   <table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
   		<thead>
			<tr>
				<th width="10px;">SL</th>
				<th>Product Name</th>
				<th>Color </th>
				<th>Size </th>
				<th width="9%">Action</th>
			</tr>
         </thead>
		 <tbody>
		 
		 </tbody>
	</table>
</div> 
                              
<!-- Edit 30.9.21 Modal yajra datatable-->
<div class="modal fade" id="EditModal" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-lg" role="document">
    <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Product Edit Modal </h5>
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
</body>

<script>
		$(".delete").on("submit", function(){
			return confirm("Are you sure to Delete the Order ?");
		});
		$('.delete').on('click', function () { 
                return confirm('Are you sure to Delete ?'); 
            }); 
		
	</script>
<script>
$(document).ready(function(){
  $("#show").click(function(){
    $("#frm").toggle();
  });
  
});
</script>

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
			ajax: "{{ route('integration.view') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'product_name', name: 'product_name'},
				{data: 'color_name', name: 'color_name'},
				{data: 'size_name', name: 'size_name'},
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
 <!-- Start Show Product with Ajax -->
<script type="text/javascript">
	$(function(){
		$(document).on('click','.show',function(){
			
			var id = $(this).data('id');
			//alert(id);
			$.get("show/"+id, function(data){
				 $('#modal_body').html(data);
			});
			
		});
	});
</script>
<!-- End Edit subcategory with Ajax -->
 <!-- Start Edit Product with Ajax -->
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

<!-- Start get data with Ajax -->
<script type="text/javascript">
	$(function(){
		$(document).on('change','#category_id',function(){
			var category_id = $(this).val();
			//alert(product_id);
			$.ajax({
				url:"{{route('get-subcategory')}}",
				type:"GET",
				data:{category_id:category_id},
				success:function(data){
					var html = '<option value="">Select Color</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.id+'">'+v.subcategory_name+'</option>';
					});
					$('#subcategory_id').html(html);
				}
			});
			
		});
	});
</script>
<!-- End get data with Ajax -->
