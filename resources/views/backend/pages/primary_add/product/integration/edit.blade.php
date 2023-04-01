<form method="post" action="{{route('integration.update')}}" id="myForm">
@csrf
	<div class="col-sm-12 float-left">
		<div class="col-sm-4 float-left">
			<div class="form-group">
				<small>Product Name:</small>
				<input type="hidden" name="id" id="id" value="{{ $stock->id }}">
				<input type="hidden" name="product_id" class="form-control" id="product_id" value="{{$stock->product_id}}" >
				<input type="text" name="product_name" class="form-control" id="product_name" value="{{$stock->product->product_name}}" required>
				<span class="text-danger">@error('product_name'){{$message}}@enderror</span>
			</div>
		</div>
		<div class="col-sm-4 float-left">
			<div class="form-group">
				<small>Product Color:</small>
				<select class="form-control select2" name="color_id" id="color_id" style="width: 100%;" tabindex="-1" required>
					<option value="">Select Category</option>
                    @foreach($colors as $row)
					<option value="{{ $row->id }}" {{($row->id == $stock->color_id)?'selected':''}}>{{ $row->color_name }}</option>
                    @endforeach
                 </select>
			</div>
		</div>
		<div class="col-sm-4 float-left">
			<div class="form-group">
				<small>Product Size:</small>
				<select class="form-control select2" name="size_id" id="size_id" style="width: 100%;" tabindex="-1" required>
                    @foreach($sizes as $row)
					<option value="{{ $row->id }}" {{($row->id == $stock->size_id)?'selected':''}}>{{ $row->size_name }}</option>
                    @endforeach
                 </select>
			</div>
		</div>
	</div>
	

<div class="modal-footer">
        <button type="submit" class="btn btn-success btn-xs">Update</button>
        <button type="button" class="btn btn-primary btn-xs" data-dismiss="modal">Close</button>
    </div>
</form>
<!-- jQuery -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
	});
</script>
<!-- Start get data with Ajax -->
<script type="text/javascript">
	$(function(){
		$(document).on('change','#category_id_e',function(){
			var category_id = $(this).val();
			//alert(product_id);
			$.ajax({
				url:"{{route('get-subcategory')}}",
				type:"GET",
				data:{category_id:category_id},
				success:function(data){
					var html = '<option value="">Select Subcategory</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.id+'">'+v.subcategory_name+'</option>';
					});
					$('#subcategory_id_e').html(html);
				}
			});
			
		});
	});
</script>