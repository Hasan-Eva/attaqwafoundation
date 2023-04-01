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
	@foreach($staffs as $data)
	<div style="page-break-after:always; padding-left:50px;">
		
			<img style="height:50px; width: 70px;" src="{{ asset('public/images/logo/logo.png') }}" >
		
		<table>
			<thead>
				<tr>
					<th colspan="9" style=" text-align:center; border:none; font-size:18px;"> <i>IMPETUS Center Owners Association</i></th>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:center; border:none;">24/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:7px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="9" style=" text-align:center; border:none; font-size:18px;"><u>Bonus Sheet </u></th>
				</tr>
				<tr>
					<td style="height:7px; border:none;"></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="3" style=" text-align:left; border:none; height:25px; width:180px;">Name of the Employee</th>
					<th style=" text-align:center; border:none;">:</th>
					<td colspan="3" style=" text-align:left; border:none; width:330px;">{{ $data->name }}</td>
					
					<th style=" text-align:right; border:none;">Staff ID : </th>
					<td style=" text-align:left; border:none;">STF/000{{ $data->id }}</td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Designation</th>
					<th style=" text-align:center; border:none;">:</th>
					<td colspan="3" style=" text-align:left; border:none;">{{ $data->designation_name }} (Building Management)</td>
					
					<th style=" text-align:right; border:none;">Date : </th>
					<td style=" text-align:left; border:none;">{{  date("d.m.Y") }}</td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Address</th>
					<th style=" text-align:center; border:none;">:</td>
					<td colspan="4" style=" text-align:left; border:none;">{{ $data->present_address }}</td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Telephone</th>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="3" style=" text-align:left; border:none;">{{ $data->phone_1 }}</td>
					
					<td style=" text-align:left; border:none;"> </td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Joining Date</th>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="3" style=" text-align:left; border:none;"> {{  date("F d, Y", strtotime($data->joining_date)) }}</td>
					
					<td style=" text-align:left; border:none;"> </td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Bonus (Eid-ul Fitar)</th>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="3" style=" text-align:left; border:none;"> {{  date("F, Y") }}</td>
					
					<td style=" text-align:left; border:none;"> </td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<td style="height:8px; border:none;"></td>
				</tr>
			</tbody>
		</table>
		<table>
				<tr>
					<th style="text-align:center;">SL</th>
					<th style="text-align:center; width:200px;">Description</th>
					<th style="text-align:center; width:100px;">Amount</th>
					<th style="text-align:center; width:100px;">Deduction</th>
					<th style="text-align:center; width:120px;">Payable Amount (figure in Tk.)</th>
				</tr>
				<tr>
					<td style="text-align:center;">1</td>
					<td style="text-align:left;">Salary for Regular Work</td>
					<td style="text-align:right;"></td>
					<td style="text-align:center;"></td>
					<td style="text-align:right;"> </td>
				</tr>
				<tr>
					<td style="text-align:center;">2</td>
					<td style="text-align:left;">Bonus</td>
					<td style="text-align:right;">{{ number_format($data->total_salary/2,0,".",",") }}</td>
					<td style="text-align:center;"></td>
					<td style="text-align:right;"> {{ number_format($data->total_salary/2,0,".",",") }}</td>
				</tr>
				<tr>
					<td style="text-align:center;">3</td>
					<td style="text-align:left;">Mobile Bill</td>
					<td style="text-align:left;"></td>
					<td style="text-align:center;"></td>
					<td style="text-align:right;"> </td>
				</tr>
				<tr>
					<th colspan="4" style="text-align:center;">Total</th>
					<th style="text-align:right; border:1px solid black;">{{ number_format($data->total_salary/2,0,".",",") }} </th>
				</tr>
			<tfoot>
				<tr>
					<td colspan="5" style=" text-align:left; height:25px; border:none;">In Word : {{ convert_number($data->total_salary/2) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:40px; border:none;"></th>
			</tr>
			<tr>
					<th style="border:none; border-top:1px solid black;  text-align:center; width:150px;">Approved by</th>
					<th style="border:none; width:90px;"> </th>
					<th style="border:none; border-top:1px solid black; width:120px;">Checked by</th>
					<th style="border:none; width:90px;"> </th>
            		<th style="border:none; border-top:1px solid black; text-align:center; width:150px;">Received by</th>
			</tr>
		</table>
	</div>
	@endforeach	
<!-- For Guards -->
	@foreach($guards as $data)
	<div style="page-break-after:always; padding-left:50px;">
		
			<img style="height: 50px;width: 70px;" src="{{ asset('public/images/logo/logo.png') }}" >
		
		<table>
			<thead>
				<tr>
					<th colspan="9" style=" text-align:center; border:none; font-size:18px;"> <i>IMPETUS Center Owners Association</i></th>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:center; border:none;">24/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:7px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="9" style=" text-align:center; border:none; font-size:18px;"><u>Bonus Sheet </u></th>
				</tr>
				<tr>
					<td style="height:8px; border:none;"></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="3" style=" text-align:left; border:none; height:25px; width:180px;">Name of the Employee</th>
					<th style=" text-align:center; border:none;">:</th>
					<td colspan="3" style=" text-align:left; border:none; width:330px;">{{ $data->name }}</td>
					
					<th style=" text-align:right; border:none;">Staff ID : </th>
					<td style=" text-align:left; border:none;">STF/000{{ $data->id }}</td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Designation</th>
					<th style=" text-align:center; border:none;">:</th>
					<td colspan="3" style=" text-align:left; border:none;">{{ $data->designation_name }} (Building Management)</td>
					
					<th style=" text-align:right; border:none;">Date : </th>
					<td style=" text-align:left; border:none;">{{  date("d.m.Y") }}</td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Address</th>
					<th style=" text-align:center; border:none;">:</td>
					<td colspan="4" style=" text-align:left; border:none;">{{ $data->present_address }}</td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Telephone</th>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="3" style=" text-align:left; border:none;">{{ $data->phone_1 }}</td>
					
					<td style=" text-align:left; border:none;"> </td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Joining Date</th>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="3" style=" text-align:left; border:none;"> {{  date("F d, Y", strtotime($data->joining_date)) }}</td>
					
					<td style=" text-align:left; border:none;"> </td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Bonus (Eid-ul Fitar)</th>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="3" style=" text-align:left; border:none;"> {{  date("F, Y") }}</td>
					
					<td style=" text-align:left; border:none;"> </td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<td style="height:8px; border:none;"></td>
				</tr>
			</tbody>
		</table>
		<table>
				<tr>
					<th style="text-align:center;">SL</th>
					<th style="text-align:center; width:200px;">Description</th>
					<th style="text-align:center; width:100px;">Amount</th>
					<th style="text-align:center; width:100px;">Deduction</th>
					<th style="text-align:center; width:120px;">Payable Amount (figure in Tk.)</th>
				</tr>
				<tr>
					<td style="text-align:center;">1</td>
					<td style="text-align:left;">Salary for Regular Work</td>
					<td style="text-align:right;"></td>
					<td style="text-align:center;"></td>
					<td style="text-align:right;"> </td>
				</tr>
				<tr>
					<td style="text-align:center;">2</td>
					<td style="text-align:left;">Bonus</td>
					<td style="text-align:right;">{{ number_format($data->total_salary/2,0,".",",") }}</td>
					<td style="text-align:center;"></td>
					<td style="text-align:right;"> {{ number_format($data->total_salary/2,0,".",",") }}</td>
				</tr>
				<tr>
					<td style="text-align:center;">3</td>
					<td style="text-align:left;">Mobile Bill</td>
					<td style="text-align:left;"></td>
					<td style="text-align:center;"></td>
					<td style="text-align:right;"> </td>
				</tr>
				<tr>
					<th colspan="4" style="text-align:center;">Total</th>
					<th style="text-align:right; border:1px solid black;">{{ number_format($data->total_salary/2,0,".",",") }} </th>
				</tr>
			<tfoot>
				<tr>
					<td colspan="5" style=" text-align:left; height:30px; border:none;">In Word : {{ convert_number($data->total_salary/2) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:40px; border:none;"></th>
			</tr>
			<tr>
					<th style="border:none; border-top:1px solid black;  text-align:center; width:150px;">Approved by</th>
					<th style="border:none; width:90px;"> </th>
					<th style="border:none; border-top:1px solid black; width:120px;">Checked by</th>
					<th style="border:none; width:90px;"> </th>
            		<th style="border:none; border-top:1px solid black; text-align:center; width:150px;">Received by</th>
			</tr>
		</table>
	</div>
	@endforeach	
<!-- For Cleaners -->
	@foreach($cleaners as $data)
	<div style="page-break-after:always; padding-left:50px;">
		
			<img style="height: 50px;width: 70px;" src="{{ asset('public/images/logo/logo.png') }}" >
		
		<table>
			<thead>
				<tr>
					<th colspan="9" style=" text-align:center; border:none; font-size:18px;"> <i>IMPETUS Center Owners Association</i></th>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:center; border:none;">24/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:8px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="9" style=" text-align:center; border:none; font-size:18px;"><u>Bonus Sheet </u></th>
				</tr>
				<tr>
					<td style="height:8px; border:none;"></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="3" style=" text-align:left; border:none; height:25px; width:250px; width:180px;">Name of the Employee</th>
					<th style=" text-align:center; border:none;">:</th>
					<td colspan="3" style=" text-align:left; border:none; width:330px;">{{ $data->name }}</td>
					
					<th style=" text-align:right; border:none;">Staff ID : </th>
					<td style=" text-align:left; border:none;">STF/000{{ $data->id }}</td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Designation</th>
					<th style=" text-align:center; border:none;">:</th>
					<td colspan="3" style=" text-align:left; border:none;">{{ $data->designation_name }} (Building Management)</td>
					
					<th style=" text-align:right; border:none;">Date : </th>
					<td style=" text-align:left; border:none;">{{  date("d.m.Y") }}</td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Address</th>
					<th style=" text-align:center; border:none;">:</td>
					<td colspan="4" style=" text-align:left; border:none;">{{ $data->present_address }}</td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Telephone</th>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="3" style=" text-align:left; border:none;">{{ $data->phone_1 }}</td>
					
					<td style=" text-align:left; border:none;"> </td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Joining Date</th>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="3" style=" text-align:left; border:none;"> {{  date("F d, Y", strtotime($data->joining_date)) }}</td>
					
					<td style=" text-align:left; border:none;"> </td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<th colspan="3" style=" text-align:left; border:none;">Bonus (Eid-ul Fitar)</th>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="3" style=" text-align:left; border:none;"> {{  date("F, Y") }}</td>
					
					<td style=" text-align:left; border:none;"> </td>
					<td style=" text-align:left; border:none;"></td>
				</tr>
				<tr>
					<td style="height:8px; border:none;"></td>
				</tr>
			</tbody>
		</table>
		<table>
				<tr>
					<th style="text-align:center;">SL</th>
					<th style="text-align:center; width:200px;">Description</th>
					<th style="text-align:center; width:100px;">Amount</th>
					<th style="text-align:center; width:100px;">Deduction</th>
					<th style="text-align:center; width:120px;">Payable Amount (figure in Tk.)</th>
				</tr>
				<tr>
					<td style="text-align:center;">1</td>
					<td style="text-align:left;">Salary for Regular Work</td>
					<td style="text-align:right;"></td>
					<td style="text-align:center;"></td>
					<td style="text-align:right;"> </td>
				</tr>
				<tr>
					<td style="text-align:center;">2</td>
					<td style="text-align:left;">Bonus</td>
					<td style="text-align:right;">{{ number_format($data->total_salary/2,0,".",",") }}</td>
					<td style="text-align:center;"></td>
					<td style="text-align:right;"> {{ number_format($data->total_salary/2,0,".",",") }}</td>
				</tr>
				<tr>
					<td style="text-align:center;">3</td>
					<td style="text-align:left;">Mobile Bill</td>
					<td style="text-align:left;"></td>
					<td style="text-align:center;"></td>
					<td style="text-align:right;"> </td>
				</tr>
				<tr>
					<th colspan="4" style="text-align:center;">Total</th>
					<th style="text-align:right; border:1px solid black;">{{ number_format($data->total_salary/2,0,".",",") }} </th>
				</tr>
			<tfoot>
				<tr>
					<td colspan="5" style=" text-align:left; height:30px; border:none;">In Word : {{ convert_number($data->total_salary/2) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:40px; border:none;"></th>
			</tr>
			<tr>
					<th style="border:none; border-top:1px solid black;  text-align:center; width:150px;">Approved by</th>
					<th style="border:none; width:90px;"> </th>
					<th style="border:none; border-top:1px solid black; width:120px;">Checked by</th>
					<th style="border:none; width:90px;"> </th>
            		<th style="border:none; border-top:1px solid black; text-align:center; width:150px;">Received by</th>
			</tr>
		</table>
	</div>
	@endforeach		
</body>