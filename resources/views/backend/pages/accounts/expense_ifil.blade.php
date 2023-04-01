<?php 
use App\Courier_br; 
use App\Models\Company_info;
?>

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
					<th colspan="2" style="text-align:right; border:none; font-size:14px;">Month : {{  date("M.Y", strtotime($f_date)) }}</th>
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
				<tr>
					<td style="text-align:left;">{{ numberToRomanRepresentation($loop->iteration) }}. {{ $row->designation_name }}</td>
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
					<td style="text-align:right;" rowspan="2">{{ number_format($row->salary_guard_office + $row->salary_guard_aegis,0) }}<?php $totalB=$row->salary_guard_office + $row->salary_guard_aegis ?></td>
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
						{{ number_format($row->electric_bill + $row->supply_water_bill + $row->generator_service + $row->lift_service + $row->bms_service + $row->internet_bill,0) }}  <?php $totalC=$row->electric_bill + $row->supply_water_bill + $row->generator_service + $row->lift_service + $row->bms_service + $row->internet_bill; ?>
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
					<td style="text-align:right;"></td>
					<td style="text-align:right;" rowspan="2">{{ number_format($row->cleaning_equipment_meterials,0) }} <?php $totalE = $row->cleaning_equipment_meterials ; ?></td>
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
                    <td style="text-align:left; height:10px; border:none;" colspan="6">In word : {{ convert_number($totalA + $totalB + $row->salary_cleaner + $totalC + $totalD + $totalE + $totalF + $totalG) }} Taka Only.</td>
                </tr>
				@endforeach
			</tbody>
			<tfoot>
				<tr>
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
				</tr>
			</tfoot>	  
		</table>
</div>
