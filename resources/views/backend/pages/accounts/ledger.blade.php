@extends('backend.layouts.master')
@section('content')
<style>
	table, th, td {
	border:1px solid #CCCCCC; 
	}
	table, th {
	text-align:center; 
	}
</style>
	<div class="card mb-4">
		<div class="card-header">
			<div class="card-header">
			<form action="{{ route('ledger.data') }}" method="post">
			@csrf
			From: <input type="date" name="f_date" value="{{ date('2020-01-01') }}" />
			To: <input type="date" name="t_date" value="{{ date('Y-m-d') }}" />
			A/c Head : <select name="h_name" required ><option value=""></option>
						@php
						$query="SELECT * FROM ac_heads";
						$data=DB::select($query);
						@endphp
						@foreach($data as $row)
						<option value="{{ $row->id }}">{{ $row->h_name }}</option>
						@endforeach
					</select>
			<button name="submit" value="Submit" style="border:none;"><i class="fa fa-search"></i></button>
			</form>
		</div>
		</div>
		@if(isset($cr))
            <div class="card-body">
                	<?php $id=request()->input('h_name'); 
						$query="SELECT * FROM ac_heads where id ='".$id."'";
						$data=DB::select($query);
					?>
                   <table>
                       <thead>
					   		<tr>
								<th colspan="8" style="border:none; text-align:center;">Company LEDGER</th>
							</tr>
							<tr>
								@foreach($data as $row)
								<td colspan="8" style="border:none; text-align:center;"><i>{{ $row->h_name }}</i></td>
								@endforeach
							</tr>
							<tr>
								@foreach($data as $row)
								<td colspan="8" style="border:none; text-align:center;"><i>From : {{  date("d.m.y", strtotime($f)) }} To : {{  date("d.m.y", strtotime($t)) }} </i></td>
								@endforeach
							</tr>
                           <tr>
                              <th rowspan="2">SL</th>
                              <th rowspan="2">Date</th>
                              <th rowspan="2" width="15%">A/c Title</th>
							  <th rowspan="2">Particulars</th>
							  <th rowspan="2" style="width:100px;">Debit</th>
							  <th rowspan="2" style="width:100px;">Credit</th>
							  <th colspan="2">Balance Amount</th>
                            </tr>
							<tr>
								<th style="width:100px;">Dr.</th><th style="width:100px;">Cr.</th>
							</tr>
                        </thead>
                    @if(isset($cr))    
                        <tbody>
						 @php $dr_total=0; $cr_total=0; @endphp
						 @foreach($cr as $data)
							<tr>
                               <td>{{ $loop->iteration }}</td>
                               <td>{{  date("d.m.y", strtotime($data->j_date)) }}</td>
                               <td style="text-align:left;">{{ $head == $data->dr_head? $data->cr_name:$data->dr_name }}</td>
							   <td style="text-align:left; text-transform:capitalize; font-size:10px;">{{ $data->particulars }}</td>
							   <td style="text-align:right;"><?php if($head == $data->dr_head){ echo number_format($data->amount,2,".",","); $dr_total+=$data->amount;} ?></td>
							   <td style="text-align:right;"><?php if($head != $data->dr_head){ echo number_format($data->amount,2,".",","); $cr_total+=$data->amount;} ?></td>
							   <td style="text-align:right;"><?php if($dr_total-$cr_total>0){ echo number_format($dr_total-$cr_total,2,".",","); } ?></td>
							  <td style="text-align:right;"><?php if($cr_total-$dr_total>0){ echo number_format($cr_total-$dr_total,2,".",","); } ?></td>
                            </tr>
						@endforeach
						 	<tr>
								<th colspan="4">Total</th>
								<th style="text-align:right;">{{ number_format($dr_total,2,".",",") }}</th>
								<th style="text-align:right;">{{ number_format($cr_total,2,".",",") }}</th>
								<th style="text-align:right;"><?php if($dr_total-$cr_total>0){ echo number_format($dr_total-$cr_total,2,".",","); } ?></th>
								<th style="text-align:right;"><?php if($cr_total-$dr_total>0){ echo number_format($cr_total-$dr_total,2,".",","); } ?></th>
							</tr>
					@endif
                     </table>
					 
                 </div>
          	@endif
         </div>	   
	</div>

@endsection

@section('scripts')
	<script>
		// Call the dataTables jQuery plugin
		$(document).ready(function() {
		  $('#dataTable').DataTable();
		});
	
	</script> 

@endsection