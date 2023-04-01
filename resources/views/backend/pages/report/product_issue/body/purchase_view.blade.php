
<table id="example1" class=" table-bordered table-striped hover">
    <thead>
		<tr>
            <th style="text-align:center; width:10px;">SL</th>
            <th style="text-align:center; width:80px;">Date</th>
			<th style="text-align:center; width:200px;">Category</th>
			<th style="text-align:center; width:450px;">Particulars</th>
			<th style="width:100px; width:50px;">Qty</th>
			<th style="text-align:center; width:450px;">Received By</th>
			<th style="width:100px; width:100px;">Rate</th>
			<th style="text-align:center; width:150px;"> Amount</th>
		</tr>
    </thead>
    <tbody>
		@php $total=0; @endphp
		@foreach($purchase as $data)
		<tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{  date("d.m.Y", strtotime($data->date)) }}</td>
            <td style="text-align:left;">{{ $data->stock->product->category->category_name }}</td>
            <td style="text-align:left;">{{ $data->stock->product->product_name }}</td>
			<td style="text-align:center;">{{ $data->quantity }}</td>
			<td style="text-align:left;">{{ $data->trade_with }}</td>
			<td class="text-right">{{ number_format($data->amount/$data->quantity,2,".",",") }}</td>
			<td class="text-right">{{ number_format($data->amount,2,".",",") }} <?php $total+=$data->amount; ?></td>
        </tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			 <th colspan="7" class="text-center">Total</th>
            <th class="text-right">{{ number_format($total,2,".",",") }}</th>
		</tr>
	</tfoot>
</table>