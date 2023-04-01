@extends('backend.layouts.master')
<!-- datatables -->
  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/datatables-buttons/css/buttons.bootstrap4.min.css">
@section('content')
    <body class="bg-primary">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-12">
                                <div class="card shadow-lg border-0 rounded-lg mt-0">
                                    <div class=""><h4 class="text-left" style="color: #FF9900;">Customer Order Summery <button class="small float-right btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal"><i class="fa fa-search"></i>Search</button></h4>
									</div>
							@if(isset($customer_order))
                                    <div class="card-footer text-center">
                                        <div class="table-responsive">
										<form method="post" action="{{route('supplier_order.gross_store')}}" id="myForm">
										 @csrf
											<table id="example1" class="table table-bordered table-hover" id="" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th style="color:#0033CC; font-size:12px;"><i>SL<i></th>
														<th style="color:#0033CC; font-size:12px;"><i>Product Image <i></th>
														<th style="color:#0033CC; font-size:12px;"><i>Product Code <i></th>
														<th style="color:#0033CC; font-size:12px;"><i>Color & Size <i></th>
														<th style="color:#0033CC; font-size:12px;"><i>Customer Order <i></th>
														<th style="color:#0033CC; font-size:12px;"><i>Order Qqantity <i></th>
														<th style="color:#0033CC; font-size:12px;"><i>Rate <i></th>
														<th style="color:#0033CC; font-size:12px;"><i>Total Price <i></th>
														<th style="color:#0033CC; font-size:12px;"><i>Action <i></th>
													</tr>
												</thead>
												<tbody>
												<?php $quantitysum=0; $advance=0; $total_price=0; $due=0;?>
												@foreach($customer_order as $row)
													<tr>
														<input type="hidden" name="stock_id[]" value="{{ $row->id }}" />
														<td style="font-size:14px; color: #0000FF;">{{ $loop->iteration }}</td>
														<td style="font-size:14px; color: #0000FF;">
															<img src="{{ asset('public/images/products/'. $row->image) }}" alt="Card image" width="50px;" />
														</td>
														<td style="font-size:14px; color: #0000FF;">{{ $row->product_name }}</td>
														<td style="font-size:14px; color: #0000FF;">Color: {{ $row->color_name }} <br/>Size: {{ $row->size_name }}</td>
														<td style="font-size:14px; color: #0000FF; text-align:center;">{{ $row->tquantity }} <input type="hidden" name="quantity[]" value="{{ $row->tquantity }}" /></td>
														<td style="font-size:14px; color: #0000FF; text-align:right;">
															<input type="number" name="buying_qty[]" class="buying_qty" value="{{ $row->tquantity }}" style="width:80px; text-align:center; border: solid #99FFCC;"/>
														</td>
														<td style="font-size:14px; color: #0000FF; text-align:right;">
															<input type="text" name="unit_price[]" class="unit_price" value="{{ $row->offer_price }}" style="width:80px; text-align:right;"/>
														</td>
														<td style="font-size:14px; color: #0000FF; text-align:right;">
															<input type="text" name="buying_price[]" class="buying_price" value="{{ $row->offer_price * $row->tquantity }}" style="max-width:60px; text-align:right; background-color:#D8FDBA; border:none;" readonly />
														</td>
														<td style="font-size:14px; color: #0000FF; text-align:right;">
															<input type="checkbox" name="action[]" value="2" checked="checked"> 
														</td>
													</tr>
												@endforeach
													
												</tbody>
												<tfoot>
													<tr>
														<th colspan="7">Total</th>
														<th style="text-align:right;">
															<input type="text" name="estimated_amount" class="estimated_amount" value="0" style="background-color:#D8FDBA; color:#FF0000; width:80px; text-align:right; border:none;" readonly />
														</th>
														<th></th>
													</tr>
												</tfoot>
											</table>
<div class="col-md-12">
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Date</label>
		<input type="date" name="date" value="{{date('Y-m-d')}}" class="form-control form-control-sm validate text-center">
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Supplier</label>
		<select name="supplier_id" class="form-control form-control-sm validate text-center select2" required>
			<option value="">Select Supplier</option>
			@foreach($suppliers as $row)
			<option value="{{$row->id}}">{{$row->supplier_name}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Action</label>
		<button type="submit" class="form-control form-control-sm btn btn-success btn-sm" onclick="return confirm('Are you sure, you want to Confirm ?');" >Confirm </button>
	</div>
</div>
											
										</form>
										</div>
                                    </div>
								@endif
                                </div>
                            </div>
                        </div>
                    </div>
          </main>
    </body>

<!-- myModal Start here-->
<div class="modal fade" id="myModal" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-md" role="document">
    <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Search By Date </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
            <!-- Modal body -->
			<form method="post" action="{{route('supplier_order.day')}}" >
			@csrf
          	<div id="modal_body form-group">
              	<div class="col-md-4 float-left p-1">
					<label for="recipient-name" class="col-form-label">From:</label>
					<input type="date" name="from" value="{{ date('Y-m-d')}}" class="form-control form-control-sm" />
				</div>  
				<div class="col-md-4 float-left p-1">
					<label for="recipient-name" class="col-form-label">To:</label>
					<input type="date" name="to" value="{{ date('Y-m-d')}}" class="form-control form-control-sm" />
				</div>
				<div class="col-md-4 float-left p-1">
					<label for="recipient-name" class="col-form-label">Category:</label>
					<select name="category_id" id="category_id" class="form-control form-control-sm select2" required>
					<option value="1" >Select </option>
					@foreach($categories as $row)
					<option value="{{ $row->id }}">{{ $row->category_name }}</option>
					@endforeach
					</select>
				</div>   
          	</div>
			 <!--/ Modal body -->
			<div class="modal-footer">
				<button type="submit" class="btn btn-warning btn btn-sm">Search</button>
				<button type="button" class="btn btn-secondary btn btn-sm" data-dismiss="modal">Close</button>
		    </div>
			</form>
      </div>
   </div>
</div>
<!-- / EditModal End here -->  	

<script type="text/javascript">
$(document).ready(function(){
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
		 
	});
</script>


@endsection