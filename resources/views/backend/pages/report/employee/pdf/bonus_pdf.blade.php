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
	<div style="">
		<div style=" padding-left:30px;">
			<img style="height:60px; width: 80px;" src="{{ asset('public/images/logo/logo.png') }}" >
		</div>
		<table>
			<thead>
				<tr>
					<th colspan="6" style=" text-align:center; border:none; font-size:18px;"> <i>IMPETUS Center Owners' Association</i></th>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:center; border:none;">24/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="6" style=" text-align:center; border:none;"><u>Bonus Sheet ( {{ $bonus_name }} - {{  date("Y", strtotime($t_date)) }} )</u></th>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:center; border:none;">(Office Staff)</td>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:left; border:none;">Date : {{  date("F d, Y", strtotime($t_date)) }}</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center; width:5px;">SL</th>
					<th style="text-align:center; width:180px;">Name</th>
					<th style="text-align:center; width:200px;">Designation</th>
					<th style="text-align:center; width:80px;"> Joining Date</th>
					<th style="text-align:center; width:90px;">Total Salary</th>
					<th style="width:100px; width:90px; ">Bonus Amount</th>
				</tr>
			</thead>
			<tbody>
				@php $total=0; $total_mobile_bill=0; $total_payable=0; @endphp
				@foreach($staffs as $data)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td style="text-align:left;">{{ $data->name }}</td>
					<td style="text-align:left;">{{ $data->designation_name }}</td>
					<td style="text-align:center;">{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
					<td style="text-align:right;">{{ number_format($data->total_salary,0,".",",") }}<?php $total+=$data->total_salary; ?></td>
					<td style="text-align:right;">{{ number_format($data->total_salary / 2,0,".",",") }} <?php $total_payable+=$data->total_salary/2; ?></td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-center">Total</th>
            		<th style="text-align:right;">{{ number_format($total,0,".",",") }}</th>
					<th style="text-align:right;">{{ number_format($total_payable,0,".",",") }} <?php $office_staff=$total_payable; ?> </th>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:left; height:30px; border:none;">In Word : {{ convert_number($total_payable) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:150px; border:none;"></th>
			</tr>
			<tr>
					<th style="border:none; border-top:1px solid black;  text-align:center; width:150px;">Prepared by</th>
					<th style="border:none; width:400px;"></th>
            		<th style="border:none; border-top:1px solid black; text-align:center; width:150px;">Approved by</th>
			</tr>
		</table>
	</div>
	<div style="page-break-before:always;">
		<div style=" padding-left:30px;">
			<img style="height:60px; width: 80px;" src="{{ asset('public/images/logo/logo.png') }}" >
		</div>
		<table>
			<thead>
				<tr>
					<th colspan="6" style=" text-align:center; border:none; font-size:18px;"><i>IMPETUS Center Owners' Association</i></th>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:center; border:none;">24/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="6" style=" text-align:center; border:none;"><u>Bonus Sheet ( {{ $bonus_name }} - {{  date("Y", strtotime($t_date)) }} )</u></th>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:center; border:none;">(Security Guard-Office)</td>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:left; border:none;">Date : {{  date("F d, Y", strtotime($t_date)) }}</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center; width:5px;">SL</th>
					<th style="text-align:center; width:210px;">Name</th>
					<th style="text-align:center; width:120px;">Designation</th>
					<th style="text-align:center; width:100px;"> Joining Date</th>
					<th style="text-align:center; width:100px;">Total Salary</th>
					<th style="width:100px; width:100px;">Bonus Amount</th>
				</tr>
			</thead>
			<tbody>
				@php $total=0; $total_mobile_bill=0; $total_payable=0; @endphp
				@foreach($guards as $data)
				<tr>
					<td style="text-align:center;">{{ $loop->iteration }}</td>
					<td style="text-align:left;">{{ $data->name }}</td>
					<td style="text-align:left;">{{ $data->designation_name }}</td>
					<td style="text-align:center;">{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
					<td style="text-align:right;">{{ number_format($data->total_salary,0,".",",") }} <?php $total+=$data->total_salary; ?></td>
					<td style="text-align:right;">{{ number_format($data->total_salary/2,0,".",",") }} <?php $total_payable+=$data->total_salary/2; ?></td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-center">Total</th>
            		<th style="text-align:right;">{{ number_format($total,0,".",",") }}</th>
					<th style="text-align:right;">{{ number_format($total_payable,0,".",",") }} <?php $security_guard=$total_payable; ?></th>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:left; height:30px; border:none;">In Word : {{ convert_number($total_payable) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:150px; border:none;"></th>
			</tr>
			<tr>
					<th style="border:none; border-top:1px solid black;  text-align:center; width:150px;">Prepared by</th>
					<th style="border:none; width:400px;"></th>
            		<th style="border:none; border-top:1px solid black; text-align:center; width:150px;">Approved by</th>
			</tr>
		</table>	
	</div>	
	<div style="page-break-before:always;">	
		<div style=" padding-left:30px;">
			<img style="height:60px; width: 80px;" src="{{ asset('public/images/logo/logo.png') }}" >
		</div>
		<table>
			<thead>
				<tr>
					<th colspan="6" style=" text-align:center; border:none; font-size:18px;"><i>IMPETUS Center Owners' Association</i></th>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:center; border:none;">24/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="6" style=" text-align:center; border:none;"><u>Bonus Sheet ( {{ $bonus_name }} - {{  date("Y", strtotime($t_date)) }} )</u></th>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:center; border:none;">(Cleaners)</td>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:left; border:none;">Date : {{  date("F d, Y", strtotime($t_date)) }}</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center; width:10px;">SL</th>
					<th style="text-align:center; width:200px;">Name</th>
					<th style="text-align:center; width:150px;">Designation</th>
					<th style="text-align:center; width:100px;"> Joining Date</th>
					<th style="text-align:center; width:100px;">Total Salary</th>
					<th style="width:100px; width:100px; ">Salary</th>
				</tr>
			</thead>
			<tbody>
				@php $total=0; $total_mobile_bill=0; $total_payable=0; @endphp
				@foreach($cleaners as $data)
				<tr>
					<td class="text-center">{{ $loop->iteration }}</td>
					<td style="text-align:left;">{{ $data->name }}</td>
					<td style="text-align:left;">{{ $data->designation_name }}</td>
					<td>{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
					<td style="text-align:right;">{{ number_format($data->total_salary,0,".",",") }} <?php $total+=$data->total_salary; ?></td>
					<td style="text-align:right;">{{ number_format($data->total_salary/2,0,".",",") }} <?php $total_payable+=$data->total_salary / 2; ?></td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-center">Total</th>
            		<th style="text-align:right;">{{ number_format($total,0,".",",") }}</th>
					<th style="text-align:right;">{{ number_format($total_payable,0,".",",") }} <?php $cleaner=$total_payable; ?></th>
				</tr>
				<tr>
					<td colspan="6" style=" text-align:left; height:30px; border:none;">In Word : {{ convert_number($total_payable) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:150px; border:none;"></th>
			</tr>
			<tr>
					<th style="border:none; border-top:1px solid black;  text-align:center; width:150px;">Prepared by</th>
					<th style="border:none; width:400px;"></th>
            		<th style="border:none; border-top:1px solid black; text-align:center; width:150px;">Approved by</th>
			</tr>
		</table>	
	</div>	
	
	<div style="page-break-before:always;">	
		<div style=" padding-left:30px;">
			<img style="height:60px; width: 80px;" src="{{ asset('public/images/logo/logo.png') }}" >
		</div>
		<table>
			<thead>
				<tr>
					<th colspan="3" style=" text-align:center; border:none; font-size:18px;"><i>IMPETUS Center Owners' Association</i></th>
				</tr>
				<tr>
					<td colspan="3" style=" text-align:center; border:none;">24/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:20px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:center; border:none; font-size:18px;"><u>Top Sheet </u></th>
				</tr>
				<tr>
					<td style="height:20px; border:none;"></td>
				</tr>
				<tr>
					<td colspan="3" style=" text-align:right; border:none; font-size:14px;">Date : {{  date("F d, Y") }}</td>
				</tr>
				<tr>
					<td colspan="3" style=" text-align:left; border:none;">Total Bonus amount for {{ $bonus_name }} {{  date("Y", strtotime($t_date)) }}.</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center; width:30px;">SL</th>
					<th style="text-align:center; width:500px;">Particulars</th>
					<th style="text-align:center; width:150px;">Total Bonus Amount</th>
				</tr>
			</thead>
			<tbody>
				@php $total=0; @endphp
				<tr>
					<td style="text-align:center;">1</td>
					<td style="text-align:left;">Building Management Office Staff (9 Persons)</td>
					<td style="text-align:right; padding-right:5px;">{{ number_format($office_staff,0,".",",") }} <?php $total+=$office_staff; ?></td>
				</tr>
				<tr>
					<td style="text-align:center;">2</td>
					<td style="text-align:left;">Building Management Security Guard (2 Persons)</td>
					<td style="text-align:right; padding-right:5px;">{{ number_format($security_guard,0,".",",") }} <?php $total+=$security_guard; ?></td>
				</tr>
				
				<tr>
					<td style="text-align:center;">3</td>
					<td style="text-align:left;">Building Management Cleaner (20 Persons)</td>
					<td style="text-align:right; padding-right:5px;">{{ number_format($cleaner,0,".",",") }} <?php $total+=$cleaner; ?></td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2" class="text-center">Total</th>
            		<th style="text-align:right; padding-right:5px;">{{ number_format($total,0,".",",") }}</th>
				</tr>
				<tr>
					<td colspan="3" style=" text-align:left; height:30px; border:none;">In Word : {{ convert_number($total) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:150px; border:none;"></th>
			</tr>
			<tr>
					<th style="border:none; border-top:1px solid black;  text-align:center; width:150px;">Prepared by</th>
					<th style="border:none; width:400px;"></th>
            		<th style="border:none; border-top:1px solid black; text-align:center; width:150px;">Approved by</th>
			</tr>
		</table>	
	</div>		
</body>