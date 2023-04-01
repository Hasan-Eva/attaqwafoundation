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
use App\Models\Staff_leave;
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
	@foreach($registers as $data)
	<div style="page-break-after:always; padding-left:50px;">
			<img style="height: 50px;width: 70px;" src="{{ asset('public/images/logo/logo.png') }}" >
		<div class="col-sm-12 float-left" style=" text-align:center;"><strong>Impetus Center </strong></div>
		<div class="col-sm-12 float-left" style=" text-align:center;">242/B, Tejgaon Gulshan Link Road, Dhaka </div>
		<div class="col-sm-12 float-left" style=" text-align:center;">Leave Register</div>
		
		<table>		
			<tbody>
				<tr>
					<td colspan="1" style=" text-align:left; border:none;">ID</td>
					<td style=" text-align:center; border:none;">:</td>
					<th colspan="1" style=" text-align:left; border:none; width:330px;">{{ $data->staff_id }}</th>
				</tr>
				<tr>
					<td colspan="1" style=" text-align:left; border:none;">Name</td>
					<td style=" text-align:center; border:none;">:</td>
					<th colspan="1" style=" text-align:left; border:none; width:330px;">{{ $data->staff->name }}</th>
				</tr>
				<tr>
					<td colspan="1" style=" text-align:left; border:none; height:25px;">Designation</td>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="1" style=" text-align:left; border:none; width:330px;">{{ $data->staff->designation->designation_name }}</td>
				</tr>
				<tr>
					<td colspan="1" style=" text-align:left; border:none; height:25px;">Duration</td>
					<td style=" text-align:center; border:none;">:</td>
					<td colspan="1" style=" text-align:left; border:none; width:330px;">{{ date("d.m.Y", strtotime($f_date)) }} to {{ date("d.m.Y", strtotime($t_date)) }}</td>
				</tr>
				<tr>
					<td colspan="1" style=" text-align:left; border:none; height:25px;"></td>
				</tr>
			</tbody>
		</table>
		<table>		
			<thead>
				<tr>
					<th style="text-align:left;">SL</th>
					<th style="text-align:center; width:100px;">From</th>
					<th style="text-align:center; width:100px;">To</th>
					<th style="text-align:center; width:80px;">Day/s</th>
					<th style="text-align:center; width:100px;">Type</th>
					<th style="text-align:center; width:150px;">Remarks</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					
					$leaves = Staff_leave::where('staff_id',$data->staff_id)->get(); 
				?>
				@foreach($leaves as $row)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{  date("d.m.Y", strtotime($row->f_date)) }}</td>
					<td>{{  date("d.m.Y", strtotime($row->t_date)) }}</td>
					<td style="text-align:center;">{{ $row->days }}</td>
					<td>{{ $row->leave_type->leave_name }}</td>
					<td>{{ $row->remarks }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		
		<table>
			<tr>
				<th style="height:30px; border:none;"></th>
			</tr>
			<tr>
				<th style="border:none; text-align:left; width:100px;">Prepared by :</th>
			</tr>
			<tr>
				<th style="height:50px; border:none;"></th>
			</tr>
			<tr>
				<th style="border:none; border-top:1px solid black;  text-align:left; width:50px;">Manager</th>
			</tr>
			<tr>
				<th style="height:50px; border:none;"></th>
			</tr>
			
		</table>
	</div>
	@endforeach	
</body>