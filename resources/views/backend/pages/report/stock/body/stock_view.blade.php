
<table id="example1" class=" table-bordered table-striped hover">
    <thead>
		<tr>
            <th style="text-align:center; width:10px;">SL</th>
            <th style="text-align:center; width:80px;">Category</th>
			<th style="text-align:center; width:450px;">Product</th>
			<th style="width:100px; width:50px;">Qty</th>
			<th style="width:100px; width:50px;">Cost of Fund</th>
		</tr>
    </thead>
    <tbody>
		@php $total=0; @endphp
		@foreach($stocks as $data)
		<tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td style="text-align:left;">{{ $data->category_name }}</td>
            <td style="text-align:left;">{{ $data->product_name }}</td>
			<td style="text-align:center;">{{ $data->stock_in_hand }}</td>
			<td style="text-align:right;">{{ number_format($data->invest,2) }} <?php $total+=$data->invest; ?></td>
        </tr>
		@endforeach
	</tbody>
		<tr>
            <th colspan="4" style="text-align:center;">Total</th>
            <th style="text-align:right;">{{ number_format($total,2) }}</th>
		</tr>
	<tfoot>
		
	</tfoot>
</table>