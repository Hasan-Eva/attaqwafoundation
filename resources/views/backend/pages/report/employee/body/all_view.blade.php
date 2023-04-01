
<table class=" table-bordered table-striped hover" width="100%">
    <thead>
		<tr>
            <th style="text-align:center; width:10px;">SL</th>
            <th style="text-align:center; width:250px;">Name</th>
			<th style="text-align:center; width:120px;">Designation</th>
			<th style="text-align:center; width:80px;"> Joining Date</th>
			<th style="text-align:center; width:100px;">Department</th>
			<th style="width:100px; width:50px;">Posting</th>
			<th style="width:100px; width:100px;">Salary</th>
		</tr>
    </thead>
    <tbody>
		@php $total=0; @endphp
		@foreach($staffs as $data)
		<tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td style="text-align:left;">{{ $data->name }}</td>
            <td style="text-align:left;">{{ $data->designation_name }}</td>
            <td>{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
			<td style="text-align:left;">{{ $data->department_name }}</td>
			<td style="text-align:left;">{{ $data->location_name }}</td>
			<td class="text-right">{{ number_format($data->total_salary,2,".",",") }} <?php $total+=$data->total_salary; ?></td>
        </tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			 <th colspan="6" class="text-center">Total</th>
            <th class="text-right">{{ number_format($total,2,".",",") }}</th>
		</tr>
		<tr>
			<td style="height:20px;"></td>
		</tr>
	</tfoot>
</table>


<table class=" table-bordered table-striped hover" width="100%">
    <thead>
		<tr>
            <th style="text-align:center; width:10px;">SL</th>
            <th style="text-align:center; width:250px;">Name</th>
			<th style="text-align:center; width:120px;">Designation</th>
			<th style="text-align:center; width:80px;"> Joining Date</th>
			<th style="text-align:center; width:100px;">Department</th>
			<th style="width:100px; width:50px;">Posting</th>
			<th style="width:100px; width:100px;">Salary</th>
		</tr>
    </thead>
    <tbody>
		@php $total=0; @endphp
		@foreach($guards as $data)
		<tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td style="text-align:left;">{{ $data->name }}</td>
            <td style="text-align:left;">{{ $data->designation_name }}</td>
            <td>{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
			<td style="text-align:left;">Cleaning</td>
			<td style="text-align:left;">{{ $data->location_name }}</td>
			<td class="text-right">{{ number_format($data->total_salary,2,".",",") }} <?php $total+=$data->total_salary; ?></td>
        </tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			 <th colspan="6" class="text-center">Total</th>
            <th class="text-right">{{ number_format($total,2,".",",") }}</th>
		</tr>
		<tr>
			<td style="height:20px;"></td>
		</tr>
	</tfoot>
</table>


<table class=" table-bordered table-striped hover" width="100%">
    <thead>
		<tr>
            <th style="text-align:center; width:10px;">SL</th>
            <th style="text-align:center; width:250px;">Name</th>
			<th style="text-align:center; width:120px;">Designation</th>
			<th style="text-align:center; width:80px;"> Joining Date</th>
			<th style="text-align:center; width:100px;">Department</th>
			<th style="width:100px; width:50px;">Posting</th>
			<th style="width:100px; width:100px;">Salary</th>
		</tr>
    </thead>
    <tbody>
		@php $total=0; @endphp
		@foreach($cleaners as $data)
		<tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td style="text-align:left;">{{ $data->name }}</td>
            <td style="text-align:left;">{{ $data->designation_name }}</td>
            <td>{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
			<td style="text-align:left;">Cleaning</td>
			<td style="text-align:left;">{{ $data->location_name }}</td>
			<td class="text-right">{{ number_format($data->total_salary,2,".",",") }} <?php $total+=$data->total_salary; ?></td>
        </tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			 <th colspan="6" class="text-center">Total</th>
            <th class="text-right">{{ number_format($total,2,".",",") }}</th>
		</tr>
	</tfoot>
</table>