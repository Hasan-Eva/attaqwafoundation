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
use App\Models\Advance_staff;
use App\Models\Absent_staff;
use App\Models\Advance_cleaner;
use App\Models\Absent_cleaner;
use App\Models\Advance_guard;
use App\Models\Absent_guard;

$f=date("Y-m-01", strtotime($t_date));
$t=date("Y-m-t", strtotime($t_date));
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
	<img style="height: 50px;width: 70px;" src="{{ asset('public/images/logo/logo.png') }}" >
		<table>
			<thead>
				<tr>
					<th colspan="10" style=" text-align:center; border:none; font-size:18px;"><i>Impetus Center </i></th>
				</tr>
				<tr>
					<td colspan="10" style=" text-align:center; border:none;">242/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="10" style=" text-align:center; border:none;"><u>Summary of Salary Sheet</u></th>
				</tr>
				<tr>
					<td colspan="10" style=" text-align:center; border:none;">(Office Staff)</td>
				</tr>
				<tr>
					<td colspan="10" style=" text-align:left; border:none;">Period : {{  date("F, Y", strtotime($t_date)) }}</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center; width:10px;">SL</th>
					<th style="text-align:center; width:145px;">Name</th>
					<th style="text-align:center; width:130px;">Designation</th>
					<th style="text-align:center; width:50px;"> Joining Date</th>
					<th style="text-align:center; width:50px;">Monthly Salary</th>
					<th style="text-align:center; width:50px;">Advance /Loan</th>
					<th style="text-align:center; width:50px;">Absent Days</th>
					<th style="text-align:center; width:50px;">Absent Day's Amount</th>
					<th style="text-align:center; width:40px;">Mobile Bill</th>
					<th style="width:100px; width:60px; ">Salary</th>
				</tr>
			</thead>
			<tbody>
				@php $staff_number=1; $total=0; $total_advance=0; $total_mobile_bill=0; $total_payable=0; $total_absent=0; @endphp
				@foreach($staffs as $data)
				<tr>
				<?php 
						$month_days = intval(date('t', strtotime($t))); // for days of the month
							$absent= Absent_staff::where('emp_id',$data->id)->whereBetween('date',[$f,$t])->first();
							if(isset($absent->total_absent)){ 
								$days = intval(date('t', strtotime($absent->date))); 
								$salary=($data->total_salary / $days) * ( $absent->total_absent );
								} else { 
								$salary=0; }
						$advances= Advance_staff::where('emp_id',$data->id)->where('balance', '>', '0')->whereBetween('date',[$f,$t])->first();
							if(isset($advances->balance)){								
								$advance= $advances->balance ;
								} else { 
								$advance=0; }
				?>
					<td class="text-center">{{ $staff_number++ }} </td>
					<td style="text-align:left;">{{ $data->name }}</td>
					<td style="text-align:left;">{{ $data->designation_name }}</td>
					<td>{{  date("d.m.y", strtotime($data->joining_date)) }}</td>
					<td style="text-align:right;"> 
					<!--
					<?php if($data->joining_date>$f) { $monthlysalary=round(($data->total_salary / $month_days) * ((strtotime($t) - strtotime($data->joining_date))/ 86400 + 1)); echo number_format($data->total_salary,0,".",",") ; $total+=$data->total_salary;} else { echo number_format($data->total_salary,0) ; $monthlysalary=$data->total_salary ; $total+=$data->total_salary; }  ?>
					-->
					{{ number_format($data->total_salary,0,".",",") }} 
					</td>
					<td style="text-align:right;">{{ $advance>0 ? number_format($advance,0):"" }} <?php $total_advance+=$advance ; ?></td>
					
					<td style="text-align:center;"><?php if(isset($absent->total_absent)){echo $absent->total_absent; } ?></td>
					<td style="text-align:right;"><?php if(isset($absent->total_absent)){echo number_format($salary,0); $total_absent+=$salary ; }  ?>  </td>
					<td style="text-align:right;"><?php if($data->mobile_bill>0) { echo number_format($data->mobile_bill,0,".",","); }  $total_mobile_bill+=$data->mobile_bill; ?></td>
					<td style="text-align:right;">{{ number_format($monthlysalary -$advance + $data->mobile_bill - $salary,0,".",",") }} <?php $total_payable+=$monthlysalary -$advance + $data->mobile_bill  - $salary ; ?></td>
				</tr>
				@endforeach
			</tbody>
			<tbody>
				@foreach($release_staffs as $data)
				<tr>
				<?php 
						$month_days = intval(date('t', strtotime($t))); 
							$absent= Absent_staff::where('emp_id',$data->id)->whereBetween('date',[$f,$t])->first();
							if(isset($absent->total_absent)){ 
								$days = intval(date('t', strtotime($absent->date))); 
								$salary=($data->total_salary / $days) * ( $absent->total_absent );
								} else { 
								$salary=0; }
						$advances= Advance_staff::where('emp_id',$data->id)->where('balance', '>', '0')->whereBetween('date',[$f,$t])->first();
							if(isset($advances->balance)){								
								$advance= $advances->balance ;
								} else { 
								$advance=0; }

				?>
					<td class="text-center">{{ $sl++ }}</td>
					<td style="text-align:left;">{{ $data->name }} <br/> (Released on {{ date('d.m.y', strtotime($data->execution_date)) }})</td>
					<td style="text-align:left;">{{ $data->designation_name }}</td>
					<td>{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
					<td style="text-align:right;"> 
					<!--
					<?php if($data->joining_date<$f) { $monthlysalary=round(($data->total_salary / $month_days) * ((strtotime($data->execution_date) - strtotime($f))/ 86400 ));  $total+=$data->total_salary;} else { $monthlysalary=round(($data->total_salary / $month_days) * ((strtotime($data->execution_date) - strtotime($data->joining_date))/ 86400 )); $total+=$data->total_salary; }  ?>
					-->
					{{ number_format($data->total_salary,0,".",",") }} 
					</td>
					<td style="text-align:right;">{{ $advance>0 ? number_format($advance,0):"" }} <?php $total_advance+=$advance ; ?></td>
					
					<td style="text-align:center;"><?php if(isset($absent->total_absent)){echo $absent->total_absent; } ?></td>
					<td style="text-align:right;"><?php if(isset($absent->total_absent)){echo number_format($salary,0); $total_absent+=$salary ; }  ?>  </td>
					<td style="text-align:right;"><?php if($data->mobile_bill>0) { echo number_format($data->mobile_bill,0,".",","); }  $total_mobile_bill+=$data->mobile_bill; ?></td>
					<td style="text-align:right;">{{ number_format($monthlysalary -$advance + $data->mobile_bill - $salary,0,".",",") }} <?php $total_payable+=$monthlysalary -$advance + $data->mobile_bill  - $salary ; ?></td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4" class="text-center">Total</th>
            		<th style="text-align:right;">{{ number_format($total,0,".",",") }}</th>
					<th style="text-align:right;">{{ $total_advance>0 ? number_format($total_advance,0,".",","): '' }}</th>
					<th style="text-align:right;"></th>
					<th style="text-align:right;">{{ $total_absent>0 ? number_format($total_absent,0,".",",") : '' }}</th>
					<th style="text-align:right;">{{ $total_mobile_bill>0 ? number_format($total_mobile_bill,0,".",","):'' }}</th>
					<th style="text-align:right;">{{ number_format($total_payable,0,".",",") }} <?php $office_staff=$total_payable; ?></th>
				</tr>
				<tr>
					<td colspan="10" style=" text-align:left; height:30px; border:none;">In Word : {{ convert_number($total_payable) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:100px; border:none;"></th>
			</tr>
			<tr>
					<th style="border:none; border-top:1px solid black;  text-align:center; width:150px;">Prepared by</th>
					<th style="border:none; width:400px;"></th>
            		<th style="border:none; border-top:1px solid black; text-align:center; width:150px;">Approved by</th>
			</tr>
		</table>
	</div>
	<div style="page-break-before:always;">
	<img style="height: 50px;width: 70px;" src="{{ asset('public/images/logo/logo.png') }}" >
		<table>
			<thead>
				<tr>
					<th colspan="9" style=" text-align:center; border:none; font-size:18px;"><i>Impetus Center </i></th>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:center; border:none;">242/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="9" style=" text-align:center; border:none;"><u>Summary of Salary Sheet</u></th>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:center; border:none;">(Security Guard-Office)</td>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:left; border:none;">Period : {{  date("F, Y", strtotime($t_date)) }}</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center; width:10px;">SL</th>
					<th style="text-align:center; width:160px;">Name</th>
					<th style="text-align:center; width:60px;"> Joining Date</th>
					<th style="text-align:center; width:60px;">Monthly Salary</th>
					<th style="text-align:center; width:70px;">Advance / Loan</th>
					<th style="text-align:center; width:70px;">Absent Days</th>
					<th style="text-align:center; width:90px;">Absent Day's Amount</th>
					<th style="text-align:center; width:60px;">Mobile Bill</th>
					<th style="width:100px; width:80px; ">Payable Salary</th>
				</tr>
			</thead>
			<tbody>
				@php $guard_number=1; $total=0; $total_advance=0; $total_mobile_bill=0; $total_payable=0; $total_absent=0; @endphp
				@foreach($guards as $data)
				<tr>
				<?php 
						$month_days = intval(date('t', strtotime($t))); 
							$absent= Absent_guard::where('emp_id',$data->id)->whereBetween('date',[$f,$t])->first();
							if(isset($absent->total_absent)){ 
								$days = intval(date('t', strtotime($absent->date))); 
								$salary=($data->total_salary / $days) * ( $absent->total_absent );
								} else { 
								$salary=0; }
						$advances= Advance_guard::where('emp_id',$data->id)->where('balance', '>', '0')->whereBetween('date',[$f,$t])->first();
							if(isset($advances->balance)){								
								$advance= $advances->balance ;
								} else { 
								$advance=0; }
				?>
					<td class="text-center">{{ $guard_number++ }}</td>
					<td style="text-align:left;">{{ $data->name }}</td>
					<td>{{  date("d.m.y", strtotime($data->joining_date)) }}</td>
					<td style="text-align:right;"> 
					<!--
					<?php if($data->joining_date>$f) { $monthlysalary=round(($data->total_salary / $month_days) * ((strtotime($t) - strtotime($data->joining_date))/ 86400 + 1)); echo number_format($data->total_salary,0,".",",") ; $total+=$data->total_salary;} else { echo number_format($data->total_salary,0) ; $monthlysalary=$data->total_salary ; $total+=$data->total_salary; }  ?>
					-->
					{{ number_format($data->total_salary,0,".",",") }} 
					</td>
					<td style="text-align:right;">{{ $advance>0 ? number_format($advance,0):"" }} <?php $total_advance+=$advance ; ?></td>
					
					<td style="text-align:center;"><?php if(isset($absent->total_absent)){echo $absent->total_absent; } ?></td>
					<td style="text-align:right;"><?php if(isset($absent->total_absent)){echo number_format($salary,0); $total_absent+=$salary ; }  ?>  </td>
					<td style="text-align:right;"><?php if($data->mobile_bill>0) { echo number_format($data->mobile_bill,0,".",","); }  $total_mobile_bill+=$data->mobile_bill; ?></td>
					<td style="text-align:right;">{{ number_format($monthlysalary -$advance + $data->mobile_bill - $salary,0,".",",") }} <?php $total_payable+=$monthlysalary -$advance + $data->mobile_bill  - $salary ; ?></td>
				</tr>
				@endforeach
			</tbody>
			<tbody>
				@foreach($release_guards as $data)
				<tr>
				<?php 
						$month_days = intval(date('t', strtotime($t))); 
							$absent= Absent_guard::where('emp_id',$data->id)->whereBetween('date',[$f,$t])->first();
							if(isset($absent->total_absent)){ 
								$days = intval(date('t', strtotime($absent->date))); 
								$salary=($data->total_salary / $days) * ( $absent->total_absent );
								} else { 
								$salary=0; }
						$advances= Advance_guard::where('emp_id',$data->id)->where('balance', '>', '0')->whereBetween('date',[$f,$t])->first();
							if(isset($advances->balance)){								
								$advance= $advances->balance ;
								} else { 
								$advance=0; }

				?>
					<td class="text-center">{{ $sl++ }}</td>
					<td style="text-align:left;">{{ $data->name }} <br/> (Released on {{ date('d.m.y', strtotime($data->execution_date)) }})</td>
					<td>{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
					<td style="text-align:right;"> 
					<!--
					<?php if($data->joining_date<$f) { $monthlysalary=round(($data->total_salary / $month_days) * ((strtotime($data->execution_date) - strtotime($f))/ 86400 ));  $total+=$data->total_salary;} else { $monthlysalary=round(($data->total_salary / $month_days) * ((strtotime($data->execution_date) - strtotime($data->joining_date))/ 86400 )); $total+=$data->total_salary; }  ?>
					-->
					{{ number_format($data->total_salary,0,".",",") }} 
					</td>
					<td style="text-align:right;">{{ $advance>0 ? number_format($advance,0):"" }} <?php $total_advance+=$advance ; ?></td>
					
					<td style="text-align:center;"><?php if(isset($absent->total_absent)){echo $absent->total_absent; } ?></td>
					<td style="text-align:right;"><?php if(isset($absent->total_absent)){echo number_format($salary,0); $total_absent+=$salary ; }  ?>  </td>
					<td style="text-align:right;"><?php if($data->mobile_bill>0) { echo number_format($data->mobile_bill,0,".",","); }  $total_mobile_bill+=$data->mobile_bill; ?></td>
					<td style="text-align:right;">{{ number_format($monthlysalary -$advance + $data->mobile_bill - $salary,0,".",",") }} <?php $total_payable+=$monthlysalary -$advance + $data->mobile_bill  - $salary ; ?></td>
				</tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<th colspan="3" class="text-center">Total</th>
            		<th style="text-align:right;">{{ number_format($total,0,".",",") }}</th>
					<th style="text-align:right;">{{ $total_advance>0 ? number_format($total_advance,0,".",","): '' }}</th>
					<th style="text-align:right;"></th>
					<th style="text-align:right;">{{ $total_absent>0 ? number_format($total_absent,0,".",",") : '' }}</th>
					<th style="text-align:right;">{{ $total_mobile_bill>0 ? number_format($total_mobile_bill,0,".",","):'' }}</th>
					<th style="text-align:right;">{{ number_format($total_payable,0,".",",") }} <?php $security_guard=$total_payable; ?></th>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:left; height:30px; border:none;">In Word : {{ convert_number($total_payable) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:100px; border:none;"></th>
			</tr>
			<tr>
					<th style="border:none; border-top:1px solid black;  text-align:center; width:150px;">Prepared by</th>
					<th style="border:none; width:400px;"></th>
            		<th style="border:none; border-top:1px solid black; text-align:center; width:150px;">Approved by</th>
			</tr>
		</table>	
	</div>	
	<div style="page-break-before:always;">	
	<img style="height: 50px;width: 70px;" src="{{ asset('public/images/logo/logo.png') }}" >
		<table>
			<thead>
				<tr>
					<th colspan="9" style=" text-align:center; border:none; font-size:18px;"><i>Impetus Center </i></th>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:center; border:none;">242/B, Tejgaon Gulshan Link Road, Dhaka</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th colspan="9" style=" text-align:center; border:none;"><u>Summary of Salary Sheet</u></th>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:center; border:none;">(Cleaners)</td>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:left; border:none;">Period : {{  date("F, Y", strtotime($t_date)) }}</td>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center; width:10px;">SL</th>
					<th style="text-align:center; width:160px;">Name</th>
					<th style="text-align:center; width:60px;"> Joining Date</th>
					<th style="text-align:center; width:60px;">Monthly Salary</th>
					<th style="text-align:center; width:70px;">Advance / Loan</th>
					<th style="text-align:center; width:70px;">Absent Days</th>
					<th style="text-align:center; width:90px;">Absent Day's Amount</th>
					<th style="text-align:center; width:60px;">Mobile Bill</th>
					<th style="width:100px; width:80px; ">Payable Salary</th>
				</tr>
			</thead>
			<tbody>
				@php $cleaner_number=1; $total=0; $total_advance=0; $total_mobile_bill=0; $total_payable=0; $total_absent=0; @endphp
				@foreach($cleaners as $data)
				<tr>
				<?php 
						$month_days = intval(date('t', strtotime($t))); 
							$absent= Absent_cleaner::where('emp_id',$data->id)->whereBetween('date',[$f,$t])->first();
							if(isset($absent->total_absent)){ 
								$days = intval(date('t', strtotime($absent->date))); 
								$salary=($data->total_salary / $days) * ( $absent->total_absent );
								} else { 
								$salary=0; }
						$advances= Advance_cleaner::where('emp_id',$data->id)->where('balance', '>', '0')->whereBetween('date',[$f,$t])->first();
							if(isset($advances->balance)){								
								$advance= $advances->balance ;
								} else { 
								$advance=0; }

				?>
					<td class="text-center">{{ $cleaner_number++ }}</td>
					<td style="text-align:left;">{{ $data->name }}</td>
					<td>{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
					<td style="text-align:right;"> 
					<!--
					<?php if($data->joining_date>$f) { $monthlysalary=round(($data->total_salary / $month_days) * ((strtotime($t) - strtotime($data->joining_date))/ 86400 + 1)); echo number_format($data->total_salary,0,".",",") ; $total+=$data->total_salary;} else { echo number_format($data->total_salary,0) ; $monthlysalary=$data->total_salary ; $total+=$data->total_salary; }  ?>
					-->
					{{ number_format($data->total_salary,0,".",",") }} 
					</td>
					<td style="text-align:right;">{{ $advance>0 ? number_format($advance,0):"" }} <?php $total_advance+=$advance ; ?></td>
					
					<td style="text-align:center;"><?php if(isset($absent->total_absent)){echo $absent->total_absent; } ?></td>
					<td style="text-align:right;"><?php if(isset($absent->total_absent)){echo number_format($salary,0); $total_absent+=$salary ; }  ?>  </td>
					<td style="text-align:right;"><?php if($data->mobile_bill>0) { echo number_format($data->mobile_bill,0,".",","); }  $total_mobile_bill+=$data->mobile_bill; ?></td>
					<td style="text-align:right;">{{ number_format($monthlysalary -$advance + $data->mobile_bill - $salary,0,".",",") }} <?php $total_payable+=$monthlysalary -$advance + $data->mobile_bill  - $salary ; ?></td>
				</tr>
				@endforeach
			</tbody>
			
			<tfoot>
				<tr>
					<th colspan="3" class="text-center">Total</th>
            		<th style="text-align:right;">{{ number_format($total,0,".",",") }}</th>
					<th style="text-align:right;">{{ $total_advance>0 ? number_format($total_advance,0,".",","): '' }}</th>
					<th style="text-align:right;"></th>
					<th style="text-align:right;">{{ $total_absent>0 ? number_format($total_absent,0,".",",") : '' }}</th>
					<th style="text-align:right;">{{ $total_mobile_bill>0 ? number_format($total_mobile_bill,0,".",","):'' }}</th>
					<th style="text-align:right;">{{ number_format($total_payable,0,".",",") }} <?php $cleaner=$total_payable; ?></th>
				</tr>
				<tr>
					<td colspan="9" style=" text-align:left; height:30px; border:none;">In Word : {{ convert_number(round($total_payable)) }} Taka Only.</td>
				</tr>
			</tfoot>	  
		</table>
		<table>
			<tr>
					<th style="height:100px; border:none;"></th>
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
					<th colspan="3" style=" text-align:center; border:none; font-size:18px;"><i>Impetus Center </i></th>
				</tr>
				<tr>
					<td colspan="3" style=" text-align:center; border:none;">242/B, Tejgaon Gulshan Link Road, Dhaka</td>
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
					<td colspan="3" style=" text-align:right; border:none; font-size:14px;">Date : {{   date("F d, Y") }}</td>
				</tr>
				<tr>
					<td colspan="3" style=" text-align:left; border:none;">Total Salary amount for the month of {{  date("F, Y", strtotime($t_date)) }}.</td>
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
					<td style="text-align:left;">Building Management Office Staff ({{ $staff_number -1}} Persons)</td>
					<td style="text-align:right; padding-right:5px;">{{ number_format($office_staff,0,".",",") }} <?php $total+=$office_staff; ?></td>
				</tr>
				<tr>
					<td style="text-align:center;">2</td>
					<td style="text-align:left;">Building Management Security Guard ({{$guard_number-1}} Persons)</td>
					<td style="text-align:right; padding-right:5px;">{{ number_format($security_guard,0,".",",") }} <?php $total+=$security_guard; ?></td>
				</tr>
				
				<tr>
					<td style="text-align:center;">3</td>
					<td style="text-align:left;">Building Management Cleaner ({{ $cleaner_number -1}} Persons)</td>
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
	
	<?php
		$query_date = $t_date; 
		$date = new DateTime($query_date); 
		//First day of month 
		$date->modify("first day of this month"); 
		$firstday= $date->format("d-m-Y"); 
		
		// echo $firstday;
	?>		
</body>