@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')
    <body class="bg-primary">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-0">
                                    <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Stock Out (Cleaners) <button class="small float-right btn btn-primary btn-xs" id="show"><i class="fa fa-plus-circle"></i> Add New</button></h4>
									</div>
     <div class="card-body" id="frm">
		<div class="col-md-12" style="float:left;">
			<div class="col-md-2" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Date</label>
					<input type="date" name="invoice_date" id="invoice_date" class="form-control form-control-sm " value="{{ date('Y-m-d')}}" required>
				</div> 
			</div>
			<div class="col-md-3" style="float:left;">
				<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Location</label>
					<select name="location_id" id="location_id" class="form-control form-control-sm select2" required />
						<option value="">Select Location</option>
						@foreach($locations as $location)
						<option value="{{ $location->id }}">{{ $location->location_name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-7" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Cleaner</label>
					<select name="cleaner_id" id="cleaner_id" class="form-control form-control-sm select2" required>
					</select>
				</div> 
			</div>
		</div> 
		<div class="col-md-12" style="float:left;">
			<div class="col-md-3" style="float:left;">
				<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Product Name</label>
					<select name="product_id" id="product_id" class="form-control form-control-sm select2" required />
						<option value="">Select Product</option>
						@foreach($stocks as $stock)
						<option value="{{ $stock->product_id }}">{{ $stock->product->product_name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-2" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Brand</label>
					<select name="brand_id" id="brand_id" class="form-control form-control-sm select2" required>
					</select>
				</div> 
			</div>
			<div class="col-md-2" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Color</label>
					<select name="color_id" id="color_id" class="form-control form-control-sm select2" required>
					</select>
				</div> 
			</div>
			<div class="col-md-2" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Size</label>
					<select name="size_id" id="size_id" class="form-control form-control-sm select2" required>
					</select>
				</div> 
			</div>
			<div class="col-md-1" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Stock</label>
					<input type="text" class="form-control form-control-sm text-right" id="stock" name="stock" value="">
				</div> 
			</div>
			<div class="col-md-1" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Rate</label>
					<input type="text" class="form-control form-control-sm text-right" id="unit_price" name="unit_price" value="">
					<input type="hidden" class="form-control form-control-sm text-right" id="unit_name" name="unit_name" value="">
				</div> 
			</div>
			<input type="hidden" name="inventory" id="inventory" value="" />
			<input type="hidden" name="order_quantity" id="order_quantity" value="" />
			<input type="hidden" name="product_price" id="product_price" value="" />
			<div class="col-md-1" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Action</label>
					<a class="btn btn-success addeventmore" id="addeventmore"><i class="fa fa-shopping-cart" aria-hidden="true"></i>  </a>
				</div> 
			</div>
		</div>
	
			</div>
		</div>   							 
	</div>	

<!--Start hidden table from here-->		
	<div class="card-body" id="addeventmore_show" style=" padding-left:5px; display:none;">
	<form method="post" action="{{route('stock_out.store')}}" id="myForm">
	@csrf
		<table class="table-sm table-bordered" width="98%" >
			<thead>
				<tr>
					<th>Product Name</th>
					<th>Brand</th>
					<th>Color</th>
					<th>Size</th>
					<th width="5%">Quantity</th>
					<th width="5%">Unit</th>
					<th width="10%">Unit Price</th>
					<th>Description</th>
					<th width="10%">Total Price</th>
					<th width="5%">Action</th>
				</tr>
			</thead>
			<tbody class="addRow" id="addRow">
			
			</tbody>
		</table>
	
		<div class="col-md-2" style="float:left; padding-top:5px;">
			<button type="submit" class="form-control form-control-md btn btn-warning" id="storeButton" onClick="return confirm('Are you sure, you want to Save the Data?');"> Confirm</button>
		</div>
		</form>
	</div>
<!-- End hidden table -->

</body>

<!-- For Handlebars JS -->
<script id="document-template" type="text/x-handlebars-template">
	<tr class="delete-add-more-item" id="delete-add-more-item">
		<input type="hidden" name="invoice_date" value="@{{invoice_date}}">
		<input type="hidden" name="cleaner_id" value="@{{cleaner_id}}">
		<input type="hidden" name="product_name[]" value="@{{product_name}}">

		<td>
			<input type="hidden" name="product_id[]" value="@{{product_id}}">@{{product_name}}  (@{{cleaner_id}})
		</td>
		<td>
			<input type="hidden" name="brand_id[]" value="@{{brand_id}}">@{{brand_name}} 
		</td>
		<td>
			<input type="hidden" name="color_id[]" value="@{{color_id}}">@{{color_name}} 
		</td>
		<td>
			<input type="hidden" name="size_id[]" value="@{{size_id}}">@{{size_name}} 
		</td>
		<td>
			<input type="text" min="1" class="form-control form-control-sm text-right buying_qty" name="buying_qty[]" value="1" >
		</td>
		<td>
			<input type="hidden" name="unit_id[]" value="@{{unit_id}}">@{{unit_name}}
		</td>
		<td>
			<input type="text" class="form-control form-control-sm text-right unit_price" name="unit_price[]" value="@{{unit_price}}" required>
		</td>
		<td>
			<input type="text" class="form-control form-control-sm" name="description[]" value="" >
		</td>
		<td>
			<input class="form-control form-control-sm text-right buying_price" name="buying_price[]" value="@{{unit_price}}" readonly >
		</td>
		<td><a title="Delete" class="btn btn-danger btn-xs removeeventmore" style="margin-left:10px;"><i class="fa fa-trash"></i></a></td>
	</tr>
</script>
<script type="text/javascript">
	$(document).ready(function(){
		 $(document).on("click",".addeventmore", function(){
			 var product_id = $('#product_id').val();
			 var purchase_no = $('#purchase_no').val();
			 var invoice_date = $('#invoice_date').val();
			 var cleaner_id = $('#cleaner_id').val();
			 var product_name = $('#product_id').find('option:selected').text();
			 var brand_id = $('#brand_id').val();
			 var brand_name = $('#brand_id').find('option:selected').text();
			 var color_id = $('#color_id').val();
			 var color_name = $('#color_id').find('option:selected').text();
			 var size_id = $('#size_id').val();
			 var size_name = $('#size_id').find('option:selected').text();
			 var unit_name = $('#unit_name').val();
			 var description = $('#description').val();
			 var buying_qty = $('#buying_qty').val();
			 var courier = $('#courier').val();
			 var courier_charge = $('#courier_charge').val();
			 var inventory = $('#inventory').val();
			 var unit_price = $('#unit_price').val();
			 var product_price = $('#product_price').val();
			 var total_p = parseFloat(unit_price * buying_qty) + parseFloat(courier_charge);
			
			 if(product_id==''){
				$.notify("Product Name is Required", {globalPosition: 'top right',className: 'error'});
				return false;
			 }
			 if(brand_id==''){
				$.notify("Brand Name is Required", {globalPosition: 'top right',className: 'error'});
				return false;
			 }
			 if(color_id==''){
				$.notify("Color Name is Required", {globalPosition: 'top right',className: 'error'});
				return false;
			 }
			 if(size_id==''){
				$.notify("Zise Name is Required", {globalPosition: 'top right',className: 'error'});
				return false;
			 }
			 if(unit_price==''){
				$.notify("Product Name is Required", {globalPosition: 'top right',className: 'error'});
				return false;
			 }
			 
			 var source = $("#document-template").html();
			 var template = Handlebars.compile(source); 
			 var data = {
					product_id:product_id,
					purchase_no:purchase_no,
					invoice_date:invoice_date,
					cleaner_id:cleaner_id,
					product_name:product_name,
					brand_id:brand_id,
					brand_name:brand_name,
					color_id:color_id,
					color_name:color_name,
					size_id:size_id,
					size_name:size_name,
					unit_name:unit_name,
					description:description,
					courier:courier,
					courier_charge:courier_charge,
					
				    inventory:inventory,
					order_quantity:order_quantity,
					unit_price:unit_price,
					product_price:product_price
				};
				var html = template(data);
				$("#addRow").append(html);	
				totalAmountPrice();
				grandtotalAmountPrice();
		 });
		 
		  $(document).on("click",".removeeventmore", function(event){
			  $(this).closest(".delete-add-more-item").remove();
			  totalAmountPrice();
			  grandtotalAmountPrice();
		 });
		 
		 $(document).on('keyup click','.unit_price,.buying_qty', function(){
		 	var unit_price = $(this).closest("tr").find("input.unit_price").val();
			var qty = $(this).closest("tr").find("input.buying_qty").val();
			var total = unit_price * qty;
			  $(this).closest("tr").find("input.buying_price").val(total);
			  totalAmountPrice();
		 });
		 
		 function totalAmountPrice(){
		 	var sum=0;
			$(".buying_price").each(function(){
				var value = $(this).val();
				if(!isNaN(value) && value.length !=0){
				 sum += parseFloat(value); 
				}
			});
			$('.estimated_amount').val(sum);
		 }
		 
		 $(document).on('keyup click','.unit_price,.buying_qty,.discount_amount,.courier_charge,.advance_avail', function(){
			var estimated_amount = $('#estimated_amount').val();
			var courier_charge = $('#courier_charge').val();
			var advance_avail = $('#advance_avail').val();
			var discount_amount = $('#discount_amount').val();
			var total = parseInt(estimated_amount) + parseInt(courier_charge) - parseInt(advance_avail) - parseInt(discount_amount);
			  $('.estimated_amount_1').val(total);
		 });
		 
		 function grandtotalAmountPrice(){
		 	var sum=0;
			$(".buying_price").each(function(){
				var value = $(this).val();
				if(!isNaN(value) && value.length !=0){
				 sum += parseFloat(value); 
				}
			});
			var courier_charge = $('#courier_charge').val();
			var advance_avail = $('#advance_avail').val();
			var discount_amount = $('#discount_amount').val();
			var total = parseInt(sum) + parseInt(courier_charge) - parseInt(advance_avail) - parseInt(discount_amount);
			$('.estimated_amount_1').val(total);
		 }
		 
	});
	
</script>
<!-- End Handlebar JS -->

<script>
	function myFunction() {
	  confirm("Press a button!");
	}
</script>
<script>
	$(document).on('click','#addeventmore',function(){
				$('#addeventmore_show').show();
			});
</script>
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
 

<!-- Start get data with Ajax -->
<script type="text/javascript">
	$(function(){
		$(document).on('change','#product_id',function(){
			var product_id = $(this).val();
			var brand_id = $('#brand_id').val();
			var color_id = $('#color_id').val();
			$.ajax({
				url:"{{route('get-brand')}}",
				type:"GET",
				data: {
                    product_id:product_id,
					brand_id:brand_id
                 },
				success:function(data){
					var html = '<option value="">Select</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.brand_id+'">'+v.brand.brand_name+'</option>';
					});
					$('#brand_id').html(html);
				}
			});
			$.ajax({
				url:"{{route('get-color')}}",
				type:"GET",
				data: {
                    product_id:product_id,
					color_id:color_id
                 },
				success:function(data){
					var html = '<option value="">Select Color</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.color_id+'">'+v.color.color_name+'</option>';
					});
					$('#color_id').html(html);
				}
			});
			$.ajax({
				url:"{{route('get-size')}}",
				type:"GET",
				data: {
                    product_id:product_id,
					color_id:color_id
                 },
				success:function(data){
					var html = '<option value="">Select</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.size_id+'">'+v.size.size_name+'</option>';
					});
					$('#size_id').html(html);
				}
			});
			$.ajax({
				url:"{{route('get-rate')}}",
				type:"GET",
				data:{product_id:product_id},
				success:function(data){
					$('#unit_price').val(data);
				}
			});
			$.ajax({
				url:"{{route('get-stock')}}",
				type:"GET",
				data:{product_id:product_id},
				success:function(data){
					$('#stock').val(data);
				}
			});
			$.ajax({
				url:"{{route('get-unit-name')}}",
				type:"GET",
				data:{product_id:product_id},
				success:function(data){
					$('#unit_name').val(data);
				}
			});
		});
		$(document).on('change','#color_id',function(){
			var color_id = $(this).val();
			var product_id = $('#product_id').val();
			$.ajax({
				url:"{{route('get-size')}}",
				type:"GET",
				data: {
                    product_id:product_id,
					color_id:color_id
                 },
				success:function(data){
					var html = '<option value="">Select</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.size_id+'">'+v.size.size_name+'</option>';
					});
					$('#size_id').html(html);
				}
			});
		});
		$(document).on('change','#brand_id',function(){
			var brand_id = $(this).val();
			var product_id = $('#product_id').val();
			$.ajax({
				url:"{{route('get-color')}}",
				type:"GET",
				data: {
                    product_id:product_id,
					brand_id:brand_id
                 },
				success:function(data){
					var html = '<option value="">Select</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.color_id+'">'+v.color.color_name+'</option>';
					});
					$('#color_id').html(html);
				}
			});
		});
		$(document).on('change','#location_id',function(){
			var location_id = $(this).val();
			$.ajax({
				url:"{{route('get-cleaner')}}",
				type:"GET",
				data: {
                    location_id:location_id
                 },
				success:function(data){
					var html = '<option value="">Select</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.name+'">'+v.name+'</option>';
					});
					$('#cleaner_id').html(html);
				}
			});
		});
	});
</script>	
<!-- End get data with Ajax -->
