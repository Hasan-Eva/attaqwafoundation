<form method="post" action="{{route('supplier_order.update')}}" id="myForm">
@csrf
<div class="col-md-12">
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<input type="hidden" name="id" id="id" value="{{ $order->id }}">
		<input type="hidden" name="stock_id" id="stock_id" value="{{ $order->stock_id }}">
		<input type="hidden" name="supplier_order_id" id="supplier_order_id" value="{{ $order->supplier_order_id }}">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Product</label>
		<p>{{ ucfirst($order->stock->product->product_name) }}<br/>Color: {{ ucfirst($order->stock->color->color_name) }}<br/>Size: {{ ucfirst($order->stock->size->size_name) }}</p>
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">C.Order</label>
		<p>{{ ucfirst($order->quantity) }}</p>
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Order Quantity</label>
		<input type="number" name="buying_qty" id="form29" class="form-control form-control-sm validate text-center" style="font-size:14px;" value="{{ $order->buying_qty }}" >
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Rate</label>
		<input type="text" name="unit_price" id="form29" class="form-control form-control-sm validate text-right" style="font-size:14px;" value="{{ $order->unit_price }}" >
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Total Price</label>
		<input type="text" name="total_price" id="form29" class="form-control form-control-sm validate text-right" style="font-size:14px;" value="{{ number_format($order->buying_qty * $order->unit_price, 0) }}" readonly>
	</div>
	<div class="col-md-2 float-left md-form ml-0 mr-0">
		<label data-error="wrong" data-success="left" for="form29" class="ml-0 mb-0 text-left">Status</label>
		<select name="status" class="form-control form-control-sm select2">
			<option value="1" {{($order->status == 1)?'selected':''}}>Confirm</option>
			<option value="0" {{($order->status == 0)?'selected':''}}>Cancel</option>
		</select>
	</div>
</div>
<div class="modal-footer">
   <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Close</button>
   <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Are you sure, you want to Update ?');">Update</button>
</div>
</form>

<!-- jQuery -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
    })
</script>