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
                                    <div class="">
										<p>Supplier : {{ $order->supplier->supplier_name }} <span style="padding-left:50px;"></span>
											Order ID : {{ $order->id }} <span style="padding-left:50px;"></span>
											 Date : {{ date("d.m.Y", strtotime($order->date)) }} 
										</p>
									</div>

                                    <div class="card-footer text-center">
                                        <div class="table-responsive">
										<form method="post" action="{{route('supplier_order.product_store')}}" id="myForm">
										 @csrf
											<table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
												<thead>
													<tr>
														<th width="30px;">SL</th>
														<th>Product</th>
														<th> Color</th>
														<th>Size</th>
														<th>Cus. Qty</th>
														<th>Order Qty</th>
														<th>Rec. Qty</th>
														<th>Price</th>
														<th>WT</th>
														<th>Shipping</th>
														<th>Total </th>
													</tr>
												</thead>
												<tbody>
													@foreach($order_details as $row)
														<tr>
															<input type="hidden" name="id[]" value="{{$row->id}}" />
															<input type="hidden" name="stock_id[]" value="{{$row->stock_id}}" />
															<input type="hidden" name="receive_qty[]" value="{{$row->receive_qty}}" />
															<input type="hidden" name="total_price[]" value="{{$row->total_price}}" />
															<input type="hidden" name="balance[]" value="{{$row->stock->balance}}" />
															<input type="hidden" name="cost_of_fund[]" value="{{$row->stock->cost_of_fund}}" />
															<td>{{ $loop->iteration }}</td>
															<td style="text-align:left; padding-left:0px;">{{ $row->stock->product->product_name }}</td>
															<td style="text-align:center; padding-left:5px;">{{ $row->stock->color->color_name }}</td>
															<td style="text-align:center; padding-left:5px;">{{ $row->stock->size->size_name }}</td>
															<td style="text-align:center; padding-left:5px;">{{ $row->quantity }} <input type="hidden" name="qty" class="qty" value="{{ $row->buying_qty }}"/></td>
															<td style="text-align:center; padding-left:5px;">{{ $row->buying_qty }} 
															  <span style="height: 25px;
																  width: 25px;
																  background-color: #bbb;
																  border-radius: 50%;
																  display: inline-block;">{{ $row->receive_qty }}
															  </span>
															</td>
															<td style="text-align:center; padding-left:5px;">
																<input type="number" name="current_receive_qty[]" class="current_receive_qty" value="" style="width:60px; background-color:#33CC33; border:none; text-align:center;" />
															</td>
															<td style="text-align:right; padding-left:5px;"><input type="text" name="unit_price[]" class="unit_price" value="{{$row->unit_price}}" style="background-color:#D8FDBA; color:#FF0000; width:60px; text-align:right; border:none;" /></td>
															<td style="text-align:right; padding-left:5px;"><input type="text" name="weight[]" class="weight" value="" style="background-color:#33CC33; color:#FF0000; width:50px; text-align:right; border:none;" /></td>
															<td style="text-align:right; padding-left:5px;"><input type="text" name="shipping_cost[]" class="shipping_cost" value="" style="background-color:#33CC33; color:#FF0000; width:80px; text-align:right; border:none;" /></td>
															<td style="text-align:right;"><input type="text" name="buying_price[]" class="buying_price" value="{{$row->unit_price * $row->current_receive_qty }}" style="background-color:#D8FDBA; color:#FF0000; width:80px; text-align:right; border:none;" readonly /></td>
															
														</tr>
													@endforeach
												</tbody>
											</table>
<div class="col-md-12">
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Date</label>
		<input type="hidden" name="order_id" value="{{ $order->id }}" />
		<input type="date" name="date" value="{{ $order->date }}" class="form-control form-control-sm validate text-center">
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Supplier</label>
		<select name="supplier_id" class="form-control form-control-sm validate text-center select2" required>
			<option value="{{$suppliers->id}}">{{$suppliers->supplier_name}}</option>
		</select>
	</div>
	<div class="col-md-1 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">O No</label>
		<input type="text" name="order_no" value="{{ $order->order_no }}" class="form-control form-control-sm validate text-center">
	</div>
	<div class="col-md-1 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Advance</label>
		<input type="text" name="advance_amount" value="{{ $order->advance_amount }}" class="form-control form-control-sm validate text-center advance" readonly>
	</div>
	<div class="col-md-1 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Total</label>
		<input type="text" name="estimated_amount" class="form-control form-control-sm validate text-right estimated_amount" value="{{ $order->total_amount }}" readonly />
	</div>
	<div class="col-md-1 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Due</label>
		<input type="text" name="due_amount" class="form-control form-control-sm validate text-right due_amount" value="{{ $order->total_amount - $order->advance_amount }}" readonly />
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Pay Type</label>
		<select name="pay_type" class="form-control form-control-sm validate text-center select2" required>
			<option value="">Select Pay Type</option>
			@foreach($pay_types as $row)
			<option value="{{$row->id}}" >{{$row->h_name}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Action</label>
		<button type="submit" class="form-control form-control-sm btn btn-success btn-sm" onClick="return confirm('Are you sure, you want to Confirm ?');" >Receive </button>
	</div>
</div>
											
										</form>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
    </body>

<script type="text/javascript">
$(document).ready(function(){
	$(document).on('keyup click change','.current_receive_qty,.unit_price,.shipping_cost', function(){
		 	var unit_price = $(this).closest("tr").find("input.unit_price").val();
			var qty = $(this).closest("tr").find("input.qty").val();
			var cost = $(this).closest("tr").find("input.shipping_cost").val();
			var total = unit_price * qty + Number(cost);
			  $(this).closest("tr").find("input.buying_price").val(total);
			  totalAmountPrice();
			  var adv = $('.advance').val();
			  var emt = $('.estimated_amount').val();
			  var due = emt - adv ;
			  $('.due_amount').val(due);
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