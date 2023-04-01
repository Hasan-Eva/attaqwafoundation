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
	<?php $f_date=request()->input('f_date'); $t_date=request()->input('t_date'); 
		$previous_period=date("Y-m-d", strtotime($f_date. ' - 1 month'));
	?>
	<body>
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
                <td colspan="8" style="text-align:left; border:none; height:10px;"> </td>
			</tr>
			<tr>
                <td colspan="8" style="text-align:left; border:none; font-size:16px;">Building Management Cost </td>
			</tr>
		</table>
		
		<table>
			<thead>
				<tr>
					<td style="height:20px; border:none;"></td>
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
				<tr>
                    <th rowspan="{{ $total_staff+1 }}">1</th>
                    <th style="text-align:left; " colspan="5"> Salary (Building Management Staff) : {{  date("F, Y", strtotime($previous_period)) }}</th>
                </tr>
				@foreach($expense as $row)
                <tr>
                    <td style="text-align:left;"> Manager</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_manager,0) }}</td>
					<td style="text-align:right;" rowspan="9">
						{{ number_format($row->salary_manager + $row->salary_civil + $row->salary_electrician + $row->salary_asst_electrician + $row->salary_store_keeper + $row->salary_bm_asst + $row->salary_imam + $row->salary_gardener,0) }}
					</td>
                </tr> 
				<tr>
                    <td style="text-align:left;"> Engineer (Civil)</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_civil,0) }}</td>
                </tr> 	  
				<tr>
                    <td style="text-align:left;"> Sr. Executive (IT)</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_civil,0) }}</td>
                </tr> 	
				<tr>
                    <td style="text-align:left;"> Electrical Technician</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_electrician,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;"> Asst. Electrical Technician</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_asst_electrician,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;"> Store Keeper</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_store_keeper,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;"> Building Management Assistant</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_bm_asst,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;"> Imam</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_imam,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;"> Guardener</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_gardener,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left; height:10px;" colspan="6"> </td>
                </tr>
				<tr>
                    <th rowspan="3">2</th>
                    <th style="text-align:left; " colspan="5"> Salary (Security Guard) : {{  date("F, Y", strtotime($previous_period)) }}</th>
                </tr>
                <tr>
                    <td style="text-align:left;"> Office (02 Persons)</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_guard_office,0) }}</td>
					<td style="text-align:right;" rowspan="2">{{ number_format($row->salary_guard_office + $row->salary_guard_aegis,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;"> Aegis (07 Persons) </td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_guard_aegis,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left; height:10px;" colspan="6"> </td>
                </tr>
				<tr>
                    <th rowspan="2">3</th>
                    <td style="text-align:left; " colspan="5"> <strong>Salary (Cleaners) :</strong> {{  date("F, Y", strtotime($previous_period)) }}</td>
                </tr>
				@foreach($cleaners as $data)
				<tr>
                    <td style="text-align:left;">Cleaners ({{ $data->cleaner_no }} Persons)</td>
				@endforeach
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->salary_cleaner,0) }}</td>
					<td style="text-align:right;">{{ number_format($row->salary_cleaner,0) }}</td>
                </tr>				
				<tr>
                    <td style="text-align:left; height:10px;" colspan="6"> </td>
                </tr>
				<tr>
                    <th rowspan="18">4</th>
                    <td style="text-align:left; " colspan="5"><strong> Maintenance Expenses : </strong>{{  date("F, Y", strtotime($t_date)) }}</td>
                </tr>
				
				<tr>
                    <td style="text-align:left;">Generator Maintenance</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->generator_maintenance,0) }}</td>
					<td style="text-align:right;" rowspan="17">{{ number_format($row->all_maintenance,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Lift Maintenance</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->lift_maintenance,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">AC Maintenance</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->ac_maintenance,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Epoxy Paint</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->epoxy_maintenance,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Water Pump</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->water_pump_maintenance,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Electrical Work</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->electrical_work,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Wooden Work</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->wooden_work,0) }}</td>
                </tr>  
				<tr>
                    <td style="text-align:left;">Glass Work</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->glass_work,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Metal Work</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->metal_work,0) }}</td>
                </tr>  
				<tr>
                    <td style="text-align:left;">Plumbing Work</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->plumbing_work,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Tiles Work</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->tiles_work,0) }}</td>
                </tr>  
				<tr>
                    <td style="text-align:left;">Civil Work</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->civil_work,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Fair Face Treatment-Outside</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->fair_face_treatment,0) }}</td>
                </tr>  
				<tr>
                    <td style="text-align:left;">Miscellaneous Maintenance</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->miscellaneous_maintenance,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Signage</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->signage,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Pest Control</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->pest_control_bill,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Garden</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->garden_maintenance,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left; height:10px;" colspan="6"> </td>
                </tr>
				<tr>
                    <th rowspan="6">5</th>
                    <th style="text-align:left; " colspan="5"> Bills : {{  date("F, Y", strtotime($previous_period)) }} </th>
                </tr>
				<tr>
                    <td style="text-align:left;">Eletricity Bills (Common Area) {{  date("F, Y", strtotime($previous_period)) }}</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->electric_bill,0) }}</td>
					<td style="text-align:right;" rowspan="6">
						{{ number_format($row->electric_bill + $row->supply_water_bill + $row->generator_service + $row->lift_service + $row->bms_service,0) }}
					</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Supply Water Bill ({{  date("F, Y", strtotime($previous_period)) }})</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->supply_water_bill,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Generator Service Bill ( {{  date("F, Y", strtotime($previous_period)) }} )</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->generator_service,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Lift Service Bill ( {{  date("F, Y", strtotime($previous_period)) }} )</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->lift_service,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">BMS Service Bill ( {{  date("F, Y", strtotime($previous_period)) }} )</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->bms_service,0) }}</td>
                </tr> 
				
				<tr>
                    <td style="text-align:left; height:10px;" colspan="6"> </td>
                </tr>
				<tr>
                    <th rowspan="3">6</th>
                    <th style="text-align:left; " colspan="5"> Stationary & Equipments : {{  date("F, Y", strtotime($t_date)) }}</th>
                </tr>
				<tr>
                    <td style="text-align:left;">Toilet Stationary</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->toilet_stationary,0) }}</td>
					<td style="text-align:right;" rowspan="2">{{ number_format($row->toilet_stationary + $row->cleaning_equipment_meterials,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Cleaning Equipments</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->cleaning_equipment_meterials,0) }}</td>
                </tr> 
				
				<tr>
                    <td style="text-align:left; height:40px; border:none;" colspan="6"> </td>
                </tr>
				<tr>
                    <th rowspan="3">7</th>
                    <th style="text-align:left; " colspan="5"> Stationary & Equipments : {{  date("F, Y", strtotime($t_date)) }}</th>
                </tr>
				<tr>
                    <td style="text-align:left;">Fuel For Generator</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->generator_fuel,0) }}</td>
					<td style="text-align:right;" rowspan="2">{{ number_format($row->generator_fuel + $row->fire_pump_fuel,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Fuel For Fire Pump</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->fire_pump_fuel,0) }}</td>
                </tr> 
				
				<tr>
                    <td style="text-align:left; height:20px; border:none;" colspan="6"> </td>
                </tr>
				<tr>
                    <th rowspan="15">8</th>
                    <th style="text-align:left; " colspan="5"> Miscellaneous : {{  date("F, Y", strtotime($t_date)) }}</th>
                </tr>
				<tr>
                    <td style="text-align:left;">Entertainment Bill (Cleaners)</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->entertainment,0) }}</td>
					<td style="text-align:right;" rowspan="14">{{ number_format($row->entertainment + $row->miscellaneous + $row->transport_bill + $row->ip_camera_maintenance + $row->drinking_water_bill + $row->garbage_bill + $row->fire_hydrant + $row->water_reservoir_clean + $row->carrying_bill + $row->exhaust_fan + $row->led_light + $row->fire_extinguisher,0) }}</td>
                </tr> 
				<tr>
                    <td style="text-align:left;">Miscellaneous </td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->miscellaneous,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;">Transport Bill </td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->transport_bill,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;">IP Camera Maintenance </td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->ip_camera_maintenance,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;">Drinking Water Bill </td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->drinking_water_bill,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;"> Garbage Bill</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->garbage_bill,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;">Fire Licence </td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->fire_hydrant,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;">Floor Mat Ground Floor-Lobby </td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
                </tr>
				<tr>
                    <td style="text-align:left;">Sewerage Line (West Site)-City Corporation</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
                </tr>
				<tr>
                    <td style="text-align:left;">Water Reservoir Clean</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->water_reservoir_clean,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;"> Carrying Bill</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->carrying_bill,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;"> Exhaust Fan</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->exhaust_fan,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;"> LED Light</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->led_light,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left;"> Fire Extingusher</td>
                    <td style="text-align:right;"></td>
					<td style="text-align:right;"></td>
					<td style="text-align:right;">{{ number_format($row->fire_extinguisher,0) }}</td>
                </tr>
				<tr>
                    <td style="text-align:left; height:10px; border:none;" colspan="6"> </td>
                </tr>
				<tr>
                    <th style="text-align:center;" colspan="5"> Total Building Managenet Cost : </th>
					<th style="text-align:right; border: 1px solid black"></th>
                </tr> 
				<tr>
                    <td style="text-align:left; height:10px; border:none;" colspan="6"> </td>
                </tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
					
				</tr>
			</tfoot>	  
		</table>
<!-- test -->

<div style="page-break-before:always;">	
	<?php $f = date("F-Y", strtotime($month_1->month)); $t = date("F-Y", strtotime($month_2->month)); ?>
	Salary (Building Management Staff) : {{ $f==$t ? $f:$f.' & '.$t }}
	<table>
		<tr>
			@foreach($staff_count as $data)
			<th style="text-align:center; width:30px;">SL {{ $data->totalstaff }}</th>
			@endforeach
			<th style="text-align:center; width:300px;">A/c Head</th>
			<th style="text-align:center; width:100px;">Date</th>
			<th style="text-align:center; width:100px;">Voucher No</th>
			<th style="text-align:center; width:120px;"> Amount</th>
		</tr>
		@php $total=0; @endphp
		@foreach($salary as $row)
		<tr>
			<td style="text-align:center;">{{ $loop->iteration }}</td>
			<td style="text-align:left;">{{ $row->designation_name }}</td>
			<td style="text-align:left;"></td>
			<td style="text-align:left;"></td>
			<td style="text-align:right;">{{ number_format($row->totalamount,0) }} <?php $total+=$row->totalamount; ?></td>
		</tr>
		@endforeach
		<tr>
			<th style="text-align:center;" colspan="4">Total</th>
			<th style="text-align:right;"> {{ number_format($total,0) }} <?php $total_staff=$total; ?></th>
		</tr>
	</table>
	Salary (Security Guard) : March, 2022
	<table>
		<tr>
			<th style="text-align:center; width:30px;">SL </th>
			<th style="text-align:center; width:300px;">A/c Head</th>
			<th style="text-align:center; width:100px;">Date</th>
			<th style="text-align:center; width:100px;">Voucher No</th>
			<th style="text-align:center; width:120px;"> Amount</th>
		</tr>
		@php $total=0; @endphp
		@foreach($guards as $row)
		<tr>
			<td style="text-align:center;">{{ $loop->iteration }}</td>
			<td style="text-align:left;">{{ $row->h_name }} {{ $row->dramount>80000 ? "March, 2022 Only":"March & April, 2022" }}</td>
			<td style="text-align:left;"></td>
			<td style="text-align:left;"></td>
			<td style="text-align:right;">{{ number_format($row->dramount,0) }} <?php $total+=$row->dramount; ?></td>
		</tr>
		@endforeach
		<tr>
			<th style="text-align:center;" colspan="4">Total</th>
			<th style="text-align:right;"> {{ number_format($total,0) }} <?php $total_guard=$total; ?></th>
		</tr>
	</table>
	
	Salary (Cleaners)  : March & April, 2022
	
	<table>
		<tr>
			<th style="text-align:center; width:30px;">SL </th>
			<th style="text-align:center; width:300px;">A/c Head</th>
			<th style="text-align:center; width:100px;">Date</th>
			<th style="text-align:center; width:100px;">Voucher No</th>
			<th style="text-align:center; width:120px;"> Amount</th>
		</tr>
		@php $total=0; @endphp
		@foreach($cleaner as $row)
		<tr>
			<td style="text-align:center;">{{ $loop->iteration }}</td>
			@foreach($cleaners as $data)
			<td style="text-align:left;">{{ $row->h_name }} - {{ $data->cleaner_no }} Persons</td>
			@endforeach
			<td style="text-align:left;"></td>
			<td style="text-align:left;"></td>
			<td style="text-align:right;">{{ number_format($row->dramount,0) }} <?php $total+=$row->dramount; ?></td>
		</tr>
		@endforeach
		<tr>
			<th style="text-align:center;" colspan="4">Total</th>
			<th style="text-align:right;"> {{ number_format($total,0) }} <?php $total_cleaner=$total; ?></th>
		</tr>
	</table>
	Maintenance & Others Expenses :  {{ date("F, Y", strtotime($f_date)) }}
	<table>
		<tr>
			<th style="text-align:center; width:30px;">SL </th>
			<th style="text-align:center; width:300px;">A/c Head</th>
			<th style="text-align:center; width:100px;">Date</th>
			<th style="text-align:center; width:100px;">Voucher No</th>
			<th style="text-align:center; width:120px;"> Amount</th>
		</tr>
		@php $total=0; @endphp
		@foreach($expt as $row)
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
			<th style="text-align:right;"> {{ number_format($total,0) }} <?php $total_others=$total; ?></th>
		</tr>
		<tr>
          	<td style="text-align:left; height:10px; border:none;" colspan="5"> </td>
         </tr>
		<tr>
			<th style="text-align:center;" colspan="4">Grand Total</th>
			<th style="text-align:right;"> {{ number_format($total_staff + $total_guard + $total_cleaner + $total_others,0) }}</th>
		</tr>
	</table>
	
</div>	

<div style="page-break-before:always;">	
	<table>
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