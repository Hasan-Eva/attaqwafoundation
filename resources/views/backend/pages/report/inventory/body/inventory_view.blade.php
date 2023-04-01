<?php $id=request()->input('h_name'); 
	$query="SELECT * FROM ac_heads where id ='".$id."'";
	$data=DB::select($query);
?>
<table id="example1" class=" table-bordered table-striped hover">
    <thead>
		<tr>
			@foreach($data as $row)
            <td colspan="8" style="text-align:center; padding-bottom:30px;"><strong>Ledger - {{ $row->h_name }}</strong> </br><i>From : {{  date("d.m.y", strtotime($f)) }} To : {{  date("d.m.y", strtotime($t)) }} </i></td>
			@endforeach
		</tr>
		<tr>
            <th rowspan="2" style="text-align:center; padding-bottom:30px;">SL</th>
            <th rowspan="2" style="text-align:center; padding-bottom:30px;">Date</th>
			<th rowspan="2" width="15%" style="text-align:center; padding-bottom:30px;">A/c Title</th>
			<th rowspan="2" width="20%" style="text-align:center; padding-bottom:30px;">Particulars</th>
			<th rowspan="2" style="width:100px; padding-bottom:30px;">Debit</th>
			<th rowspan="2" style="width:100px; padding-bottom:30px;">Credit</th>
			<th colspan="2" style="text-align:center;">Balance Amount</th>
		</tr>
		<tr>
			<th style="width:100px; text-align:center;">Dr.</th><th style="width:100px; text-align:center;">Cr.</th>
		</tr>
    </thead>
    <tbody>
		<tr>
            <td></td>
            <td colspan="5" class="text-center"> Opening Balance</td>
            <td style="text-align:right;"><?php if( $opening_dr - $opening_cr > 0) { echo number_format($opening_dr - $opening_cr,2,".",","); $openingdr=$opening_dr - $opening_cr;} else { $openingdr=0; } ?></td>
			<td style="text-align:right;"><?php if( $opening_dr - $opening_cr < 0) { echo number_format($opening_cr - $opening_dr,2,".",","); $openingcr=$opening_cr - $opening_dr;} else { $openingcr=0; } ?></td>
        </tr>
                 	  
		@php $dr_total=0; $cr_total=0; @endphp
		@foreach($cr as $data)
		<tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{  date("d.m.y", strtotime($data->j_date)) }}</td>
            <td style="text-align:left;">{{ $head == $data->dr_head? $data->cr_name:$data->dr_name }}</td>
			<td style="text-align:left; text-transform:capitalize; font-size:12px;">{{ $data->particulars }}</td>
			<td style="text-align:right;"><?php if($head == $data->dr_head){ echo number_format($data->amount,2,".",","); $dr_total+=$data->amount;} ?></td>
			<td style="text-align:right;"><?php if($head != $data->dr_head){ echo number_format($data->amount,2,".",","); $cr_total+=$data->amount;} ?></td>
			<td style="text-align:right;"><?php if($dr_total-$cr_total+$openingdr-$openingcr>0){ echo number_format($dr_total-$cr_total+$openingdr-$openingcr,2,".",","); } ?></td>
			<td style="text-align:right;"><?php if($cr_total-$dr_total+$openingcr-$openingdr>0){ echo number_format($cr_total-$dr_total + $openingcr-$openingdr,2,".",","); } ?></td>
        </tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr>
			<th colspan="4" class="text-center">Closing Balance</th>
			<th style="text-align:right;">{{ number_format($dr_total,2,".",",") }}</th>
			<th style="text-align:right;">{{ number_format($cr_total,2,".",",") }}</th>
			<th style="text-align:right;"><?php if($dr_total-$cr_total+$openingdr-$openingcr>0){ echo number_format($dr_total-$cr_total+$openingdr-$openingcr,2,".",","); } ?></th>
			<th style="text-align:right;"><?php if($cr_total-$dr_total+$openingcr-$openingdr>0){ echo number_format($cr_total-$dr_total+ $openingcr-$openingdr,2,".",","); } ?></th>
		</tr>
	</tfoot>
</table>