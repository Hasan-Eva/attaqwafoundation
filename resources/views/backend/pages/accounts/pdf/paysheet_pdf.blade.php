<?php
function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Number is out of range");
    } 
	$Cn = floor($number / 10000000);  /* Crore (giga) */ 
    $number -= $Cn * 10000000; 

    $Gn = floor($number / 100000);  /* Lac (giga) */ 
    $number -= $Gn * 100000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 
	if ($Cn) 
    { 
        $res .= convert_number($Cn) . " Crore"; 
    } 

    if ($Gn) 
    { 
        $res .= (empty($res) ? "" : " ") .
		convert_number($Gn) . " Lac"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($kn) . " Thousand"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") . 
            convert_number($Hn) . " Hundred"; 
    } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
        "Nineteen"); 
    $tens = array("", "", "Twenty", "Thirty", "Forty", "Fifty", "Sixty", 
        "Seventy", "Eigthy", "Ninety"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " and "; 
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= " " . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "zero"; 
    } 

    return $res; 
} 

?>
<?php 
use App\Courier_br; 
use App\Models\Company_info;
?>

<style>
table {
  font-family: arial, sans-serif;
  font-style: italic;
  font-size:13px;
  border-collapse: collapse;
}
h1 {
  width: 200px;
  height: 20px;
  background-color: yellow;
  -ms-transform: skewY(20deg); /* IE 9 */
  transform: skewY(20deg);
}
td, th {
    border: 1px solid black;
}
</style>
	<body>
		<?php 
			$company_name = Company_info::first()->name;
			$company_address = Company_info::first()->address;
		?>
		<div style=" padding-left:30px;">
			<img style="height:30px; width: 60px; position:absolute;" src="{{ asset('public/images/logo/logo.png') }}" >
		</div>
		<table style="margin-top:0px; width:100%;">
			<tr>
                <td colspan="8" style="text-align:center; border:none; font-size:16px;"><strong>{{ $company_name }}</strong> </td>

			</tr>
			<tr>
                <td colspan="8" style="text-align:center; border:none;"> {{ $company_address }}  </td>
			</tr>
			<tr>
                <td colspan="8" style="text-align:center; border:none; height:2px;"> </td>
			</tr>
			<tr>
                <td colspan="8" style="text-align:left; border:none;"><i>Daily Payment Sheet : {{  date("d.m.y", strtotime($f)) }} to {{  date("d.m.y", strtotime($t)) }} </i></td>
			</tr>
		</table>
		
		<table>
			<thead>
				<tr>
					<td style="height:2px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center; width:10px;">Vr. No</th>
					<th style="text-align:center; width:65px;">Date</th>
					<th style="text-align:center; width:140px;">A/c Title</th>
					<th style="text-align:center; width:355px;">Particulars</th>
					<th style="width:20px;">Ref. No</th>
					<th style="width:60px;">Amount</th>
			</thead>
			<tbody>
			@if(isset($cr)) 
				@php $dr_total=0; $cr_total=0; @endphp
				@foreach($cr as $data)
				<tr>
                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                    <td style="text-align:center;">{{  date("d.m.Y", strtotime($data->j_date)) }}</td>
                    <td style="text-align:left; padding:3px;">{{ $data->dr_name }}</td>
					<td style="text-align:left; padding:3px; text-transform:capitalize; font-size:12px;">{{ $data->particulars }}</td>
					<td style="text-align:center; padding:3px;">{{ $data->ref_no }}</td>
					<td style="text-align:right; padding:3px;"><?php echo number_format($data->amount,2,".",","); $cr_total+=$data->amount; ?></td>
                </tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-center"> Total</th>
					<th style="text-align:right; padding:3px;"></th>
					<th style="text-align:right; padding:3px;">{{ number_format($cr_total,2,".",",") }}</th>
				</tr>
			</tfoot>
			@endif	  
		</table>	
		
		
<table>
	<thead>
		<tr>
			<td style="height:5px; border:none;"></td>
		</tr>
		<tr>
			<th colspan="5" style="border:none;">Cash A/c</th>
		</tr>
		<tr>
			<th style="text-align:center;">Vr. No</th>
			<th style="text-align:center; width:260px;">Description</th>
			<th style="text-align:center; width:100px;">Dr Amount</th>
			<th style="text-align:center; width:130px;">Cr Amount</th>
			<th style="width:120px;">Balance Amount</th>
		</tr>
	</thead>
		
	<tbody>	
		<tr>
			<td style="text-align:center;">1</td>
			<td >Opening Balance </td>
            <td style="text-align:right;"><!-- {{  number_format($opening_dr,2,".",",") }} --></td>
            <td style="text-align:right;"><!-- {{  number_format($opening_cr,2,".",",") }} --></td>
            <td style="text-align:right;">{{  number_format($opening_dr - $opening_cr,2,".",",") }}</td>
		</tr>
		<tr>
			<td style="text-align:center;">2</td>
			<td >Cash Received</td>
            <td style="text-align:right;">{{  number_format($cash_received,2,".",",") }}</td>
            <td style="text-align:right;"></td>
            <td style="text-align:right;">{{  number_format($opening_dr - $opening_cr + $cash_received ,2,".",",") }}</td>
		</tr>
		<tr>
			<td style="text-align:center;">3</td>
			<td >Cash Payment</td>
            <td style="text-align:right;"></td>
            <td style="text-align:right;">{{  number_format($cr_total,2,".",",") }}</td>
            <td style="text-align:right;">{{  number_format($opening_dr - $opening_cr + $cash_received - $cr_total,2,".",",") }}</td>
		</tr>
		<tr>
			<td style="text-align:center;">4</td>
			<th colspan="3">Closing Balance</th>
            <th style="text-align:right;">{{  number_format($opening_dr - $opening_cr + $cash_received - $cr_total,2,".",",") }}</th>
		</tr>
	</tbody>
</table>	

<!--
<table>
	<thead>
		<tr>
			<td style="height:5px; border:none;"></td>
		</tr>
		<tr>
			<th colspan="5" style="border:none;">Bank A/c</th>
		</tr>
		<tr>
			<th style="text-align:center;">Vr. No</th>
			<th style="text-align:center; width:250px;">Description</th>
			<th style="text-align:center; width:100px;">Dr Amount</th>
			<th style="text-align:center; width:120px;">Cr Amount</th>
			<th style="width:120px;">Balance Amount</th>
		</tr>
	</thead>
		
	<tbody>
		<tr>
			<td style="text-align:center;">1</td>
			<td >Opening Balance</td>
            <td style="text-align:right;">{{  number_format($bank_dr,2,".",",") }}</td>
            <td style="text-align:right;">{{  number_format($bank_cr,2,".",",") }}</td>
            <td style="text-align:right;">{{  number_format($bank_dr - $bank_cr - $bank_charge_previous,2,".",",") }}</td>
		</tr>
		<tr>
			<td style="text-align:center;">2</td>
			<td >Cash Deposit</td>
            <td style="text-align:right;">{{  number_format($bank_received_dr,2,".",",") }}</td>
            <td style="text-align:right;"></td>
            <td style="text-align:right;">{{  number_format($bank_dr - $bank_cr + $bank_received_dr,2,".",",") }}</td>
		</tr>
		<tr>
			<td style="text-align:center;">3</td>
			<td >Cash Withdrawal</td>
            <td style="text-align:right;"></td>
            <td style="text-align:right;">{{  number_format($bank_received_cr,2,".",",") }}</td>
            <td style="text-align:right;">{{  number_format($bank_dr - $bank_cr + $bank_received_dr - $bank_received_cr,2,".",",") }}</td>
		</tr>
		<tr>
			<td style="text-align:center;">3</td>
			<td >Bank Charge (All Charges)</td>
            <td style="text-align:right;"></td>
            <td style="text-align:right;">{{  number_format($bank_cgarge_current,2,".",",") }}</td>
            <td style="text-align:right;">{{  number_format($bank_dr - $bank_cr + $bank_received_dr - $bank_received_cr - $bank_cgarge_current,2,".",",") }}</td>
		</tr>
		<tr>
			<td style="text-align:center;">4</td>
			<th colspan="3">Closing Balance</th>
            <th style="text-align:right;">{{  number_format($bank_dr - $bank_cr + $bank_received_dr - $bank_received_cr,2,".",",") }}</th>
		</tr>
		
		
	</tbody>
</table>	
-->
	<!-- Check Payment Start here -->
		<table style="width:640px;">
			<thead>
				<tr>
					<td style="height:5px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="5" style="border:none;">Cheque Payments</th>
				</tr>	
				<tr>
					<th style="text-align:center; width:35px;">Vr. No</th>
					<th style="text-align:center; width:50px;">Date</th>
					<th style="text-align:center; width:120px;">A/c Title</th>
					<th style="text-align:center; width:300px;">Particulars</th>
					<th style="width:60px;">Amount</th>
			</thead>
			<tbody>
			@if(isset($cr)) 
				@php $dr_total=0; $cheque_total=0; @endphp
				@foreach($cheque as $data)
				<tr>
                    <td style="text-align:center;">{{ $loop->iteration }}</td>
                    <td style="text-align:center;">{{  date("d.m.Y", strtotime($data->j_date)) }}</td>
                    <td style="text-align:left; padding:3px;">{{ $data->dr_name }}</td>
					<td style="text-align:left; padding:3px; text-transform:capitalize; font-size:12px;">{{ $data->particulars }}</td>
					<td style="text-align:right; padding:3px;"><?php echo number_format($data->amount,2,".",","); $cheque_total+=$data->amount; ?></td>
                </tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-center"> Total</th>
					<th style="text-align:right; padding:3px;">{{ number_format($cheque_total,2,".",",") }}</th>
				</tr>
			</tfoot>
			@endif	  
		</table>	
	<!-- Check Payment End here -->
	<!-- Total Payment Start here -->
		<table style="width:665px;">
			<thead>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				
			</thead>
			<tbody>
				<tr>
					<td style="text-align:center; width:500px;"><strong> Grand Total </strong>( Cash + Cheque )</td>
					<th style="text-align:right; padding:3px; width:100px;">{{ number_format($cr_total + $cheque_total,2,".",",") }}</th>
				</tr>
			</tbody>
			<tfoot>
				
			</tfoot>  
		</table>	
	<!-- Total Payment End here -->
<table>
	<tr>
			<td style="height:50px; border:none;"></td>
	</tr>
	<tr>
		<td style="text-align:center; width:100px; border:none; border-top:1px solid black;">Prepared By</td>
		<td style="text-align:center; width:450px; border:none;"></td>
		<td style="text-align:center; width:100px; border:none; border-top:1px solid black;">Approved By</td>
	</tr>
</table>
</body>