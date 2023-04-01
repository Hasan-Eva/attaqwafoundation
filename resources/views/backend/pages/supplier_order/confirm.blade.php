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
							@if(isset($order_details))
                                    <div class="card-footer text-center">
                                        <div class="table-responsive">
										<form method="post" action="{{route('supplier_order.gross_store_update')}}" id="myForm">
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
												@foreach($order_details as $row)
													<tr>
														<input type="hidden" name="supplier_order_id[]" value="{{ $row->supplier_order_id }}" />
														<input type="hidden" name="stock_id[]" value="{{ $row->stock_id }}" />
														<td style="font-size:14px; color: #0000FF;">{{ $loop->iteration }}</td>
														<td style="font-size:14px; color: #0000FF;">
															<img src="{{ asset('public/images/products/'. $row->stock->product->image) }}" alt="Card image" width="50px;" />
														</td>
														<td style="font-size:14px; color: #0000FF;">{{ $row->stock->product->product_name }}</td>
														<td style="font-size:14px; color: #0000FF;">Color: {{ $row->stock->color->color_name }} <br/>Size: {{ $row->stock->size->size_name }}</td>
														<td style="font-size:14px; color: #0000FF; text-align:center;">{{ $row->quantity }} <input type="hidden" name="quantity[]" value="{{ $row->quantity }}" /></td>
														<td style="font-size:14px; color: #0000FF; text-align:center;">{{ $row->buying_qty }}</td>
														<td style="font-size:14px; color: #0000FF; text-align:right;">{{ number_format($row->unit_price, 0) }}</td>
														<td style="font-size:14px; color: #0000FF; text-align:right;">{{ number_format($row->unit_price * $row->buying_qty, 0) }}<?php $total_price+=$row->unit_price * $row->buying_qty; ?> </td>
														<td class="cart_delete text-center">
															<a class="cart_quantity_delete edit" id="getEditData" data-id="{{$row->id}}" data-toggle="modal" data-target="#EditModal" title="Edit Product">
															@if($row->status==0)<i class="fa fa-times"></i>
															@elseif($row->status==1)<i class="fa fa-check"></i>
															@endif
															</a>		
														</td>
													</tr>
												
												@endforeach
													
												</tbody>
												<tfoot>
													<tr>
														<th colspan="7">Total</th>
														<th style="text-align:right;">{{ number_format($total_price, 0) }}</th>
														<th></th>
													</tr>
												</tfoot>
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
			<option value="">Select Supplier</option>
			@foreach($suppliers as $row)
			<option value="{{$row->id}}" {{($order->supplier_id == $row->id)?'selected':''}}>{{$row->supplier_name}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-1 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">O No</label>
		<input type="text" name="order_no" value="{{ $order->order_no }}" class="form-control form-control-sm validate text-center">
	</div>
	<div class="col-md-1 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Advance</label>
		<input type="text" name="advance_amount" value="{{ $order->advance_amount }}" class="form-control form-control-sm validate text-center">
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Pay Type</label>
		<select name="pay_type" class="form-control form-control-sm validate text-center select2" required>
			<option value="">Select Pay Type</option>
			@foreach($pay_types as $row)
			<option value="{{$row->id}}" {{($order->pay_type == $row->id)?'selected':''}}>{{$row->h_name}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Total</label>
		<input type="text" name="total_amount" value="{{ $total_price }}" class="form-control form-control-sm validate text-right" readonly>
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Action</label>
		<button type="submit" class="form-control form-control-sm btn btn-success btn-sm" onClick="return confirm('Are you sure, you want to Confirm ?');" >Confirm </button>
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

<!-- EditModal Start here-->
<div class="modal fade" id="EditModal" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-lg" role="document">
    <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Change Product </h5>
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
<!-- / EditModal End here --> 	

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    })
</script>
<!-- EditModal -->
<script type="text/javascript">
	$(function(){
		$(document).on('click','.edit',function(){
			var id = $(this).data('id');
			//alert(id);
			$.get("../supplierorderedit/"+id, function(data){
				 $('#modal_body').html(data);
			});
			
		});
	});
</script>

@endsection