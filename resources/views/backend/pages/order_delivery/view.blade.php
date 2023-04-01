@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')
    <body class="bg-primary">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-0">
                                    <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Invoice Generate <button class="small float-right btn btn-primary btn-xs" id="show"><i class="fa fa-plus-circle"></i> Add New</button></h4>
									</div>
     <div class="card-body" id="frm">
		<div class="col-md-12" style="float:left;">
			<div class="col-md-3" style="float:left;">
				<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Customer Name</label>
					<select name="customer_id" id="customer_id" class="form-control form-control-sm select2" required />
					<option value="">Select Customer</option>
						@foreach($customers as $row)
						<option value="{{ $row->customer->id }}">{{ $row->customer->customer_name }} ({{ $row->customer->phone_1 }})</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-2" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Order No</label>
					<select name="order_id" id="order_id" class="form-control form-control-sm select2" required>
					</select>
				</div> 
			</div>
			<div class="col-md-3" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Product</label>
					<select name="product_id" id="product_id" class="form-control form-control-sm select2" required>
					</select>
				</div> 
			</div>
			<div class="col-md-2" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Date</label>
					<input type="date" name="invoice_date" id="invoice_date" class="form-control form-control-sm " value="{{ date('Y-m-d')}}" required>
				</div> 
			</div>
			<input type="hidden" name="inventory" id="inventory" value="" />
			<input type="hidden" name="unit_price" id="unit_price" value="" />
			<input type="hidden" name="order_quantity" id="order_quantity" value="" />
			<input type="hidden" name="product_price" id="product_price" value="" />
			<div class="col-md-2" style="float:left;">
            	<div class="form-group"><label class="small mb-1" for="inputEmailAddress">Action</label>
					<a class="btn btn-success addeventmore" id="addeventmore"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add to Invoice</a>
				</div> 
			</div>
		</div> 
	
			</div>
		</div>   							 
	</div>	

<!--Start hidden table from here-->		
	<div class="card-body" id="addeventmore_show" style=" padding-left:5px; display:none;">
	<form method="post" action="{{route('delivery.store')}}" id="myForm">
	@csrf
		<table class="table-sm table-bordered" width="98%" >
			<thead>
				<tr>
					<th style="width:25%;">Product Details</th>
					<th style="width:3%;">Stock</th>
					<th style="width:3%;">Quantity</th>
					<th width="5%">Unit Price</th>
					<th width="6%">Total Price</th>
					<th width="2%">Action</th>
				</tr>
			</thead>
			<tbody class="addRow" id="addRow">
			
			</tbody>
			<tbody>
				<tr>
					<td colspan="4" style="text-align:center;"><input type="text" name="" value="Total" class="form-control form-control-sm text-right" readonly style="background-color:#D8FDBA;"></td>
					<td><input type="text" name="estimated_amount" id="estimated_amount" class="form-control form-control-sm text-right estimated_amount" readonly style="background-color:#D8FDBA;">
					</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center;"><input type="text" name="" value="Courier Charge" class="form-control form-control-sm text-right" style="background-color:#99FFFF;"></td>
					<td><input type="text" name="courier_charge" value="0" id="courier_charge" class="form-control form-control-sm text-right courier_charge" style="background-color:#99FFFF;">
					</td>
					<td></td>
				</tr>
				<tr>
					<th colspan="4" style="text-align:center;"><input type="text" name="" value="Advanced Amount" class="form-control form-control-sm text-right" readonly style="background-color:#99FFCC;">
					</th>
					<th><input type="text" name="advance_avail" value="0" id="advance_avail" class="form-control form-control-sm text-right advance_avail" style="background-color:#99FFCC;">
					</th>
					<td><input type="text" id="advance_show" value="" class="form-control form-control-sm text-right advance_show" readonly></td>
				</tr>
				<tr>
					<td colspan="4" style="text-align:center;"><input type="text" name="" value="Special Discount" class="form-control form-control-sm text-right" style="background-color: #99FF99;"></td>
					<td><input type="text" name="discount_amount" value="0" id="discount_amount" class="form-control form-control-sm text-right discount_amount" style="background-color:#99FF99;">
					</td>
					<td></td>
				</tr>
				<tr>
					<th colspan="4" style="text-align:center;"><input type="text" name="" value="Grand Total" class="form-control form-control-sm text-right" readonly style="background-color:#66FF66;">
					</th>
					<th><input type="text" name="estimated_amount_1" value="0" id="estimated_amount_1" class="form-control form-control-sm text-right estimated_amount_1" readonly style="background-color:#66FF66;">
					</th>
					<td></td>
				</tr>
		<!--
				<tr>
					<td colspan="4" style="text-align:center;">
							<select name="courier" id="courier" class="form-control courier"  >
								<option value=""></option>
								@foreach($couriers as $courier)
									<option value="{{ $courier->id }}">{{ $courier->name }} </option>
								@endforeach
							</select>
					</td>
					<td>
					</td>
					<td></td>
				</tr>
		-->		
			</tbody>
		</table>
	
		<div style="float:left; width:200px;">
			
		</div>
		<div style="float:left; width:200px;">
			<button type="submit" class="btn btn-primary" id="storeButton" onClick="return confirm('Are you sure, you want to Generate Invoice ?');"><i class="fa fa-plus-circle"></i> Submit</button>
		</div>
		</form>
	</div>
<!-- End hidden table -->

</body>

<!-- For Handlebars JS -->
<script id="document-template" type="text/x-handlebars-template">
	<tr class="delete-add-more-item" id="delete-add-more-item">
		
		<input type="hidden" name="customer_id" value="@{{customer_id}}">
		<input type="hidden" name="order_id" value="@{{order_id}}">
		<input type="hidden" name="invoice_date" value="@{{invoice_date}}">
		<input type="hidden" name="product_name[]" value="@{{product_name}}">
		
		<td>
			<input type="hidden" name="product_id[]" value="@{{product_id}}">@{{order_id}} - @{{product_name}} 
		</td>
		<td>
			<input type="number" class="form-control form-control-sm text-right inventory" name="inventory[]" value="@{{inventory}}" readonly>
		</td>
		<td>
			<input type="number" class="form-control form-control-sm text-center order_quantity" name="order_quantity[]" value="@{{order_quantity}}" readonly>
		</td>
		<td>
			<input type="text" class="form-control form-control-sm text-right unit_price" name="unit_price[]" value="@{{unit_price}}" readonly>
		</td>
		<td>
			<input class="form-control form-control-sm text-right product_price" name="product_price[]" value="@{{product_price}}" readonly>
		</td>
		<td><a title="Delete" class="btn btn-danger btn-xs removeeventmore" style="margin-left:10px;"><i class="fa fa-trash"></i></a></td>
	</tr>
</script>
<script type="text/javascript">
	$(document).ready(function(){
		 $(document).on("click",".addeventmore", function(){
			 var product_id = $('#product_id').val();
			 var order_id = $('#order_id').val();
			 var invoice_date = $('#invoice_date').val();
			 var product_name = $('#product_id').find('option:selected').text();
			 var brand_id = $('#brand_id').val();
			 var brand_name = $('#brand_id').find('option:selected').text();
			 var color_id = $('#color_id').val();
			 var color_name = $('#color_id').find('option:selected').text();
			 var size_id = $('#size_id').val();
			 var size_name = $('#size_id').find('option:selected').text();
			 
			 var description = $('#description').val();
			 var customer_id = $('#customer_id').val();
			 var customer_name = $('#customer_name').val(); 
			 var address = $('#address').val();
			 var upazila_id = $('#upazila_id').val();
			 var phone_1 = $('#phone_1').val();
			 var phone_2 = $('#phone_2').val();
			 var email = $('#email').val();
			 var customer_id = $('#customer_id').val();
			 var buying_qty = $('#buying_qty').val();
			 var courier = $('#courier').val();
			 var courier_charge = $('#courier_charge').val();
			 var inventory = $('#inventory').val();
			 var order_quantity = $('#order_quantity').val();
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
			 if(customer_id==''){
				$.notify("Zise Name is Required", {globalPosition: 'top right',className: 'error'});
				return false;
			 }
			  if(order_id==''){
				$.notify("Product Name is Required", {globalPosition: 'top right',className: 'error'});
				return false;
			 }
			 
			 var source = $("#document-template").html();
			 var template = Handlebars.compile(source); 
			 var data = {
					product_id:product_id,
					order_id:order_id,
					invoice_date:invoice_date,
					product_name:product_name,
					brand_id:brand_id,
					brand_name:brand_name,
					color_id:color_id,
					color_name:color_name,
					size_id:size_id,
					size_name:size_name,
					
					description:description,
					customer_id:customer_id,
					customer_name:customer_name,
					address:address,
					upazila_id:upazila_id,
					phone_1:phone_1,
					phone_2:phone_2,
					email:email,
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
		 
		 $(document).on('keyup click','.unit_price,.order_quantity,.discount_amount,.courier_charge,.advance_avail', function(){
		 	var unit_price = $(this).closest("tr").find("input.unit_price").val();
			var qty = $(this).closest("tr").find("input.order_quantity").val();
			var discount_amount = $(this).closest("tr").find("input.discount_amount").val();
			var total = (unit_price * qty);
			  $(this).closest("tr").find("input.product_price").val(total);
			  totalAmountPrice();
		 });
		 
		 function totalAmountPrice(){
		 	var sum=0;
			$(".product_price").each(function(){
				var value = $(this).val();
				if(!isNaN(value) && value.length !=0){
				 sum += parseFloat(value); 
				}
			});
			$('.estimated_amount').val(sum);
		 }
		 
		 $(document).on('keyup click','.unit_price,.order_quantity,.discount_amount,.courier_charge,.advance_avail', function(){
			var estimated_amount = $('#estimated_amount').val();
			var courier_charge = $('#courier_charge').val();
			var advance_avail = $('#advance_avail').val();
			var discount_amount = $('#discount_amount').val();
			var total = parseInt(estimated_amount) + parseInt(courier_charge) - parseInt(advance_avail) - parseInt(discount_amount);
			  $('.estimated_amount_1').val(total);
		 });
		 
		 function grandtotalAmountPrice(){
		 	var sum=0;
			$(".product_price").each(function(){
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
		$(document).on('change','#customer_id',function(){
			var customer_id = $(this).val();
			//alert(customer_id);
			$.ajax({
				url:"{{route('get-order')}}",
				type:"GET",
				data:{customer_id:customer_id},
				success:function(data){
					var html = '<option value="">Select Order</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.id+'">'+v.id+') '+v.customer_order_date+'</option>';
					});
					$('#order_id').html(html);
				}
			});
			
		});
	});
	$(function(){
		$(document).on('change','#order_id',function(){
			var order_id = $(this).val();
			//alert(customer_id);
			$.ajax({
				url:"{{route('get-product')}}",
				type:"GET",
				data:{order_id:order_id},
				success:function(data){
					var html = '<option value="">Select Product</option>';
					$.each(data,function(key,v){
						html += '<option value="'+v.id+'">'+v.id+') '+v.product_name+' '+v.color_name+' '+v.size_name+'</option>';
					});
					$('#product_id').html(html);
				}
			});
			
		});
	});
	$(function(){
		$(document).on('change','#order_id',function(){
			var order_id = $(this).val();
			$.ajax({
				url:"{{route('get-courier-charge')}}",
				type:"GET",
				data:{order_id:order_id},
				success:function(data){
					$('#courier_charge').val(data);
				}
			});
		});
	});
	$(function(){
		$(document).on('change','#order_id',function(){
			var order_id = $(this).val();
			$.ajax({
				url:"{{route('get-advance-avail')}}",
				type:"GET",
				data:{order_id:order_id},
				success:function(data){
					$('#advance_avail').val(data);
					$('#advance_show').val(data);
				}
			});
		});
	});
	$(function(){
		$(document).on('change','#product_id',function(){
			var order_details_id = $(this).val();
			$.ajax({
				url:"{{route('get-unit-stock')}}",
				type:"GET",
				data:{order_details_id:order_details_id},
				success:function(data){
					$('#inventory').val(data);
				}
			});
		});
	});
	$(function(){
		$(document).on('change','#product_id',function(){
			var order_details_id = $(this).val();
			$.ajax({
				url:"{{route('get-order-qantity')}}",
				type:"GET",
				data:{order_details_id:order_details_id},
				success:function(data){
					$('#order_quantity').val(data);
				}
			});
		});
	});
	$(function(){
		$(document).on('change','#product_id',function(){
			var order_details_id = $(this).val();
			$.ajax({
				url:"{{route('get-unit-price')}}",
				type:"GET",
				data:{order_details_id:order_details_id},
				success:function(data){
					$('#unit_price').val(data);
				}
			});
		});
	});
	$(function(){
		$(document).on('change','#product_id',function(){
			var order_details_id = $(this).val();
			$.ajax({
				url:"{{route('get-total-price')}}",
				type:"GET",
				data:{order_details_id:order_details_id},
				success:function(data){
					$('#product_price').val(data);
				}
			});
		});
	});
</script>
<!-- End get data with Ajax -->
