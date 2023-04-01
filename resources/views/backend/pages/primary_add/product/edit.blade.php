<form method="post" action="{{route('product.update')}}" id="myForm">
@csrf
	<div class="col-sm-12 float-left">
		<div class="col-sm-12 foat-left">
			<div class="form-group">
				<small>Product Name:</small>
				<input type="hidden" name="id" id="id" value="{{ $product->id }}">
				<input type="text" name="product_name" class="form-control" id="product_name" value="{{$product->product_name}}" required>
				<span class="text-danger">@error('product_name'){{$message}}@enderror</span>
			</div>
		</div>
		<div class="col-sm-6 float-left">
			<div class="form-group">
				<small>Category Name:</small>
				<select class="form-control select2" name="category_id" id="category_id_e" style="width: 100%;" tabindex="-1" required>
					<option value="">Select Category</option>
                    @foreach($categories as $row)
					<option value="{{ $row->id }}" {{($row->id == $product->category_id)?'selected':''}}>{{ $row->category_name }}</option>
                    @endforeach
                 </select>
			</div>
			<div class="form-group">
				<small>Unit Name:</small>
				<select class="form-control select2" name="unit_id" id="unit_id" style="width: 100%;" tabindex="-1" required>
                    @foreach($units as $row)
					<option value="{{ $row->id }}" {{($row->id == $product->unit_id)?'selected':''}}>{{ $row->unit_name }}</option>
                    @endforeach
                 </select>
			</div>
		</div>
		<div class="col-sm-6 float-left">
			<div class="form-group">
				<small>Sub-category Name:</small>
				<select class="form-control select2" name="subcategory_id" id="subcategory_id_e" style="width: 100%;" tabindex="-1" required>
                    @foreach($subcategories as $row)
					<option value="{{ $row->id }}" {{($row->id == $product->subcategory_id)?'selected':''}}>{{ $row->subcategory_name }}</option>
                    @endforeach
                 </select>
			</div>
			<div class="form-group">
				<small>Purchase Price:</small>
				<input type="text" name="purchase_price" class="form-control" id="purchase_price" value="{{$product->purchase_price}}" required>
				<span class="text-danger">@error('purchase_price'){{$message}}@enderror</span>
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