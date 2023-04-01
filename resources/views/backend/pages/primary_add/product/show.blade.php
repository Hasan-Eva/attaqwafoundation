<div class="card-body">
   <table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
   		<thead>
			<tr>
				<th width="10px;">SL</th>
				<th>Product Name</th>
				<th>Color </th>
				<th>Size </th>
				<th>Stock Balance</th>
				<th width="9%">Action</th>
			</tr>
         </thead>
		 <tbody>
		 	@foreach($stocks as $row)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{$row->product->product_name}}</td>
				<td>{{$row->color->color_name}}</td>
				<td style="text-align:center;">{{$row->size->size_name}}</td>
				<td style="text-align:right; padding-right:5px;">{{$row->balance}}</td>
				<td></td>
			</tr>
			@endforeach
		 </tbody>
	</table>
</div> 