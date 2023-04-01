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

// start
function numberToRomanRepresentation($number) {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
}

?>
<?php 
use App\Courier_br; 
use App\Models\Company_info;
use App\Models\Salary_staff;
?>

<style>
table {
  font-family: arial, sans-serif;
  font-style: italic;
  font-size:11px;
  border-collapse: collapse;
}

td, th {
    border: 1px solid black;
	height: 5px;
}

</style>
	<?php 
		$f_date=request()->input('f_date'); $t_date=request()->input('t_date'); 
		$previous_period=date("Y-m-d", strtotime($f_date. ' - 1 month'));
	?>
<body>
<div style="page-break-before:always;">	
		<div style=" padding-left:30px;">
			<img style="height:40px; width: 60px; position:absolute;" src="{{ asset('public/images/logo/logo.png') }}" >
		</div>

		<table style="margin-top:0px; width:100%; ">
			<tr>
                <td colspan="8" style="text-align:center; border:none; font-size:20px;"><strong>{{ Company_info::first()->name }}</strong> </td>
			</tr>
			<tr>
                <td colspan="8" style="text-align:center; border:none;"><i>Period : {{  date("d.m.Y", strtotime($f_date)) }} To {{  date("d.m.Y", strtotime($t_date)) }} </i></td>
			</tr>
			<tr>
                <td colspan="8" style="text-align:left; border:none; height:10px;"></td>
			</tr>
		</table>
		
		<table>
			<thead>
				<tr>
					<th colspan="4" style="text-align:left; border:none; font-size:14px;">Building Management Total Cost</th>
					<th colspan="2" style="text-align:right; border:none; font-size:14px;">Month : {{  date("M, Y", strtotime($f_date)) }}</th>
				</tr>
				<tr>
					<td style="height:10px; border:none;"></td>
				</tr>
				<tr>
					<th style="text-align:center;">SL</th>
					<th style="text-align:center; width:330px;">Particulars</th>
					<th style="text-align:center; width:70px;">Date</th>
					<th style="text-align:center; width:80px;">Voucher No</th>
					<th style="width:80px;">Amount</th>
					<th style="width:120px;">Total Amount</th>
				</tr>
			</thead>
			<tbody>
				@foreach($staff_count as $data)
					<?php $total_staff = $data->totalstaff; ?>
				@endforeach
				@php $totalA=0; @endphp
				@foreach($salary as $row)
					<?php $totalA+=$row->totalamount; ?>
				@endforeach
				<tr>
                    <th rowspan="{{ $total_staff+1 }}">1</th>
                    <td contenteditable='true' style="text-align:left; " colspan="4"> <strong>Salary (Building Management Staff) : </strong>{{  date("F, Y", strtotime($previous_period)) }}</td>
					<th rowspan="{{ $total_staff+1 }}" style="text-align:right;"> {{ number_format($totalA,0) }} </th>
                </tr>
				@foreach($salary as $row)
				@php $staff_number=Salary_staff::Where ('designation_id', $row->designation_id)->whereBetween('salary_date',[$f_date,$t_date])->count('id'); @endphp
				<tr>
					<td style="text-align:left;">{{ numberToRomanRepresentation($loop->iteration) }}. {{ $row->designation_name }}  {{ ($staff_number>1)?"(". $staff_number ." Persons)":"" }}</td>
					<td style="text-align:left;"></td>
					<td style="text-align:left;"></td>
					<td style="text-align:right;">{{ number_format($row->totalamount,0) }}</td>
				</tr>
				@endforeach
				
				@foreach($expense as $row)
				
				<tr>
                    <th rowspan="3">2</th>
                    <td contenteditable='true' style="text-align:left; " colspan="5"> <strong>Salary (Security Guard) : </strong>{{  date("F, Y", strtotime($previous_period)) }}</td>
                </tr>
                <tr>
                    <td style="text-align:left;">I. Office (02 Persons)</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_guard_office,0) }}</td>
					<td style="text-align:right;" rowspan="2">{{ number_format($row->salary_guard_office + $row->salary_guard_aegis,0) }}<?php $totalB=$row->salary_guard_office + $row->salary_guard_aegis ; ?></td>
                </tr> 
				<tr>
                    <td contenteditable='true' style="text-align:left;">II. Aegis (08 Persons) </td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_guard_aegis,0) }}</td>
                </tr>
				
				<tr>
                    <th rowspan="2">3</th>
                    <td contenteditable='true' style="text-align:left; " colspan="5"> <strong> Salary (Cleaners) :</strong> {{  date("F, Y", strtotime($previous_period)) }}</td>
                </tr>
				@foreach($cleaners as $data)
				<tr>
                    <td style="text-align:left;">I. Cleaners ({{ $data->cleaner_no }} Persons)</td>
				@endforeach
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_cleaner,0) }}</td>
					<td style="text-align:right;">{{ number_format($row->salary_cleaner,0) }}</td>
                </tr>	
								
				<tr>
                    <th rowspan="7">4</th>
                    <td contenteditable='true' style="text-align:left; " colspan="5"> <strong>Bills :</strong> {{  date("F, Y", strtotime($previous_period)) }} </td>
                </tr>
				<tr>
                    <td contenteditable='true' style="text-align:left;">I. Electricity Bills (Common Area) {{  date("F, Y", strtotime($previous_period)) }}</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->electric_bill,0) }}</td>
					<td style="text-align:right;" rowspan="6">
						{{ number_format($row->electric_bill + $row->supply_water_bill + $row->generator_service + $row->lift_service + $row->bms_service + $row->internet_bill,0) }} <?php $totalC=$row->electric_bill + $row->supply_water_bill + $row->generator_service + $row->lift_service + $row->bms_service + $row->internet_bill; ?>
					</td>
                </tr> 
				<tr>
                    <td contenteditable='true' style="text-align:left;">II. Supply Water Bill ({{  date("F, Y", strtotime($previous_period)) }})</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->supply_water_bill,0) }}</td>
                </tr> 
				<tr>
                    <td contenteditable='true' style="text-align:left;">III. Generator Service Bill ( {{  date("F, Y", strtotime($previous_period)) }} )</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->generator_service,0) }}</td>
                </tr> 
				<tr>
                    <td contenteditable='true' style="text-align:left;">IV. Lift Service Bill ( {{  date("F, Y", strtotime($previous_period)) }} )</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->lift_service,0) }}</td>
                </tr> 
				<tr>
                    <td contenteditable='true' style="text-align:left;">V. BMS Service Bill ( {{  date("F, Y", strtotime($previous_period)) }} )</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->bms_service,0) }}</td>
                </tr> 
				<tr>
                    <td contenteditable='true' style="text-align:left;">VI. Internet Bill ( {{  date("F, Y", strtotime($previous_period)) }} )</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->internet_bill,0) }}</td>
                </tr> 
				
				@php $totalD=0; @endphp
				@foreach($maintenances as $maintenance)
					<?php $totalD+=$maintenance->dramount; ?>
				@endforeach			
				<tr>
                    <th rowspan="{{ $maintenance_count->count()+1 }}">5</th>
                    <td style="text-align:left; " colspan="4"><strong> Maintenance Expenses : </strong>{{  date("F, Y", strtotime($t_date)) }} </td>
					<th rowspan="{{ $maintenance_count->count()+1 }}" style="text-align:right;">{{ number_format($totalD,0) }}</th>
                </tr>
				@foreach($maintenances as $mainteetance)
				<tr>
					<td style="text-align:left;">{{ numberToRomanRepresentation($loop->iteration) }}. {{ $mainteetance->h_name }}</td>
					<td style="text-align:left;"></td>
					<td style="text-align:left;"></td>
					<td style="text-align:right;">{{ number_format($mainteetance->dramount,0) }}</td>
				</tr>
				@endforeach
				
				<tr>
                    <th rowspan="3">6</th>
                    <td style="text-align:left; " colspan="5"> <strong>Toilet Stationary & Equipments :</strong> {{  date("F, Y", strtotime($t_date)) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;">I. Toilet Stationary</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->toilet_stationary,0) }}</td>
					<td style="text-align:right;" rowspan="2">{{ number_format($row->toilet_stationary + $row->cleaning_equipment_meterials,0) }} <?php $totalE = $row->toilet_stationary + $row->cleaning_equipment_meterials ; ?></td>
                </tr> 
				<tr>
                    <td style="text-align:left;">II. Cleaning Equipments & Matetials</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->cleaning_equipment_meterials,0) }}</td>
                </tr> 
				
				<tr>
                    <th rowspan="3">7</th>
                    <td style="text-align:left; " colspan="5"><strong> Fuel Expenses : </strong>{{  date("F, Y", strtotime($t_date)) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;">I. Fuel For Generator</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->generator_fuel,0) }}</td>
					<td style="text-align:right;" rowspan="2">{{ number_format($row->generator_fuel + $row->fire_pump_fuel,0) }}<?php $totalF = $row->generator_fuel + $row->fire_pump_fuel ; ?></td>
                </tr> 
				<tr>
                    <td style="text-align:left;">II. Fuel For Fire Pump</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->fire_pump_fuel,0) }}</td>
                </tr> 
				@php $totalG=0; @endphp
				@foreach($miscellaneous_expenses as $miscellaneous_expense)
					<?php $totalG+=$miscellaneous_expense->dramount; ?>
				@endforeach	
				<tr>
                    <th rowspan="{{ $miscellaneous_count->count()+1 }}">8</th>
                    <td style="text-align:left; " colspan="4"> <strong>Miscellaneous Expenses :</strong> {{  date("F, Y", strtotime($t_date)) }} </td>
					<th rowspan="{{ $miscellaneous_count->count()+1 }}" style="text-align:right;">{{ number_format($totalG,0) }}</th>
                </tr>
				@foreach($miscellaneous_expenses as $miscellaneous_expense)
				<tr>
					<td style="text-align:left;">{{ numberToRomanRepresentation($loop->iteration) }}. {{ $miscellaneous_expense->h_name }}</td>
					<td style="text-align:left;"></td>
					<td style="text-align:left;"></td>
					<td style="text-align:right;">{{ number_format($miscellaneous_expense->dramount,0) }}</td>
				</tr>
				@endforeach
				
				<tr>
                    <td style="text-align:left; height:10px; border:none;" colspan="6"> </td>
                </tr>
				<tr>
                    <th style="text-align:center;" colspan="5"> Total Building Managenet Cost : </th>
					<th style="text-align:right; border: 1px solid black">{{ number_format($totalA + $totalB + $row->salary_cleaner + $totalC + $totalD + $totalE + $totalF + $totalG,0) }}</th>
                </tr> 
				<tr>
                    <td style="text-align:left; height:10px; border:none;" colspan="6">In word : {{ convert_number($totalA + $totalB + $row->salary_cleaner + $totalC + $totalD + $totalE  + $totalF + $totalG) }} Taka Only.</td>
                </tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td style="border:none; height:40px;"></td>
				</tr>
				<tr>
					<td colspan="2" style="border:none;">-------------------</td>
					<td colspan="6" style="border:none; text-align:right;">-------------------</td>
				</tr>
				<tr>
					<td colspan="2" style="border:none;">Prepared by</td>
					<td colspan="6" style="border:none; text-align:right;">Checked by</td>
				</tr>
			</tfoot>	  
		</table>
<!-- test -->
</div>


@include('backend.pages.accounts.expense_ifil')




<div style="page-break-before:always;">	
	
	<table>
		<tr>
			<th colspan="4" style="text-align:left; border:none; font-size:14px;">Building Management Cost</th>
			<th colspan="2" style="text-align:right; border:none; font-size:14px;">Month : {{  date("M.Y", strtotime($f_date)) }}</th>
		</tr>
		<tr>
			<td style="height:10px; border:none;"></td>
		</tr>
		<tr>
			<th style="text-align:center; width:30px;">SL </th>
			<th style="text-align:center; width:300px;">A/c Head</th>
			<th style="text-align:center; width:100px;">Date</th>
			<th style="text-align:center; width:100px;">Voucher No</th>
			<th style="text-align:center; width:120px;"> Amount</th>
		</tr>
		@php $total=0; @endphp
		@foreach($exp as $row)
		<tr>
			<td style="text-align:center;">{{ $loop->iteration }}</td>
			<td style="text-align:left;">{{ $row->h_name }}</td>
			<td style="text-align:left;"></td>
			<td style="text-align:left;"></td>
			<td style="text-align:right;">{{ number_format($row->dramount,0) }} <?php $total+=$row->dramount; ?></td>
		</tr>
		@endforeach
		
		<tr>
			<th style="text-align:center;" colspan="4">Total</th>
			<th style="text-align:right;"> {{ number_format($total,0) }}</th>
		</tr>
	</table>
</div>			
</body>