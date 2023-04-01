
<style>
	table, th, td {
	border:1px solid #CCCCCC; 
	}
	table, th {
	text-align:center; 
	}
</style>
<div class="card-body">
  <?php $f_date=request()->input('f_date'); $t_date=request()->input('t_date'); ?>
   <table id="example1" class=" table-bordered table-striped hover">
        <thead>
			<tr>
				<th colspan="4" style="border:none; text-align:center;">Trail Balance </th>
			</tr>
			<tr>
				<td colspan="4" style="border:none; text-align:center;">Period : {{ date("d.m.Y", strtotime($f_date)) }} to {{ date("d.m.Y", strtotime($t_date)) }}</td>
			</tr>
            <tr>
                <th width="5%">SL</th>
                <th style="width:250px;">Particulars</th>
				<th width="15%">Debit</th>
				<th width="15%">Credit</th>
            </tr>
        </thead>
        <tbody>
		@if(isset($trailbalance))
			@php $total_dr=0; $total_cr=0; $sl=1; @endphp
			@foreach($trailbalance as $data)
			@if(isset($data->capital_dr) OR isset($data->capital_cr))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Capital A/c</td>
				<td style="text-align:right;">@if($data->capital_dr - $data->capital_cr>0){{ number_format($data->capital_dr - $data->capital_cr,2,".",",") }} <?php $total_dr+=$data->capital_dr - $data->capital_cr; ?> @endif</td>
				<td style="text-align:right;">@if($data->capital_dr - $data->capital_cr<=0){{ number_format($data->capital_cr - $data->capital_dr,2,".",",") }} <?php $total_cr+=$data->capital_cr - $data->capital_dr; ?>@endif</td>
            </tr>
			@endif
			@if(isset($data->cash_dr) OR isset($data->cash_cr))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Cash A/c</td>
				<td style="text-align:right;">@if($data->cash_dr - $data->cash_cr>0){{ number_format($data->cash_dr - $data->cash_cr,2,".",",") }}  <?php $total_dr+=$data->cash_dr - $data->cash_cr; ?>  @endif</td>
				<td style="text-align:right;">@if($data->cash_dr - $data->cash_cr<=0){{ number_format($data->cash_cr - $data->cash_dr,2,".",",") }} <?php $total_cr+=$data->cash_cr - $data->cash_dr; ?>@endif</td>
            </tr>
			@endif
			@if(isset($data->bank_dr) OR isset($data->bank_cr))
			<tr>
				<td>{{ $sl++ }}</td>
				<td style="text-align:left;">Bank A/c</td>
				<td style="text-align:right;">@if($data->bank_dr - $data->bank_cr>0){{ number_format($data->bank_dr - $data->bank_cr,2,".",",") }}  <?php $total_dr+=$data->bank_dr - $data->bank_cr; ?> @endif</td>
				<td style="text-align:right;">@if($data->bank_dr - $data->bank_cr<=0){{ number_format($data->bank_cr - $data->bank_dr,2,".",",") }} <?php $total_cr+=$data->bank_cr - $data->bank_dr; ?> @endif</td>
            </tr>
			@endif	
			@if(isset($data->salary_manager))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Manager)</td>
				<td style="text-align:right;">{{ number_format($data->salary_manager,2,".",",") }} <?php $total_dr+=$data->salary_manager ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_civil))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Engineer-Civil)</td>
				<td style="text-align:right;">{{ number_format($data->salary_civil,2,".",",") }} <?php $total_dr+=$data->salary_civil ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif	
			@if(isset($data->salary_it))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(IT)</td>
				<td style="text-align:right;">{{ number_format($data->salary_it,2,".",",") }} <?php $total_dr+=$data->salary_it ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_reception))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Reception)</td>
				<td style="text-align:right;">{{ number_format($data->salary_reception,2,".",",") }} <?php $total_dr+=$data->salary_reception ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_electrical))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Electrical In-Charge)</td>
				<td style="text-align:right;">{{ number_format($data->salary_electrical,2,".",",") }} <?php $total_dr+=$data->salary_electrical ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_asst_electrical))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Asst. Electrical)</td>
				<td style="text-align:right;">{{ number_format($data->salary_asst_electrical,2,".",",") }} <?php $total_dr+=$data->salary_asst_electrical ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_store_incharge))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Store In-Charge)</td>
				<td style="text-align:right;">{{ number_format($data->salary_store_incharge,2,".",",") }} <?php $total_dr+=$data->salary_store_incharge ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_store_keeper))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Store Keeper)</td>
				<td style="text-align:right;">{{ number_format($data->salary_store_keeper,2,".",",") }} <?php $total_dr+=$data->salary_store_keeper ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_bm_asst))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Building Mgt. Assistant)</td>
				<td style="text-align:right;">{{ number_format($data->salary_bm_asst,2,".",",") }} <?php $total_dr+=$data->salary_bm_asst ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_imam))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Imam)</td>
				<td style="text-align:right;">{{ number_format($data->salary_imam,2,".",",") }} <?php $total_dr+=$data->salary_imam ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_gardener))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Gardener)</td>
				<td style="text-align:right;">{{ number_format($data->salary_gardener,2,".",",") }} <?php $total_dr+=$data->salary_gardener ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_guard_office))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Guard-Office)</td>
				<td style="text-align:right;">{{ number_format($data->salary_guard_office,2,".",",") }} <?php $total_dr+=$data->salary_guard_office ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_guard_aegis))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Guard-Aegis)</td>
				<td style="text-align:right;">{{ number_format($data->salary_guard_aegis,2,".",",") }} <?php $total_dr+=$data->salary_guard_aegis ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->salary_cleaner))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Salary(Cleaner)</td>
				<td style="text-align:right;">{{ number_format($data->salary_cleaner,2,".",",") }} <?php $total_dr+=$data->salary_cleaner ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->electric_bill))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Electric Bill</td>
				<td style="text-align:right;">{{ number_format($data->electric_bill,2,".",",") }} <?php $total_dr+=$data->electric_bill ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->supply_water_bill))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Supply Water Bill</td>
				<td style="text-align:right;">{{ number_format($data->supply_water_bill,2,".",",") }} <?php $total_dr+=$data->supply_water_bill ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->drinking_water_bill))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Drinking Water Bill</td>
				<td style="text-align:right;">{{ number_format($data->drinking_water_bill,2,".",",") }} <?php $total_dr+=$data->drinking_water_bill ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->entertainment))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Entertainment </td>
				<td style="text-align:right;">{{ number_format($data->entertainment,2,".",",") }} <?php $total_dr+=$data->entertainment ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->internet_bill))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Internet Bill</td>
				<td style="text-align:right;">{{ number_format($data->internet_bill,2,".",",") }} <?php $total_dr+=$data->internet_bill ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->house_rent))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">House Rent</td>
				<td style="text-align:right;">{{ number_format($data->house_rent,2,".",",") }} <?php $total_dr+=$data->house_rent ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->garbage_bill))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Garbage Bill</td>
				<td style="text-align:right;">{{ number_format($data->garbage_bill,2,".",",") }} <?php $total_dr+=$data->garbage_bill ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->pest_control_bill))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Pest Control Bill</td>
				<td style="text-align:right;">{{ number_format($data->pest_control_bill,2,".",",") }} <?php $total_dr+=$data->pest_control_bill ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->generator_service))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Generator Service</td>
				<td style="text-align:right;">{{ number_format($data->generator_service,2,".",",") }} <?php $total_dr+=$data->generator_service ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->lift_service))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Lift Service</td>
				<td style="text-align:right;">{{ number_format($data->lift_service,2,".",",") }} <?php $total_dr+=$data->lift_service ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->bms_service))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">BMS Service</td>
				<td style="text-align:right;">{{ number_format($data->bms_service,2,".",",") }} <?php $total_dr+=$data->bms_service ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->generator_fuel))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Generator Fuel</td>
				<td style="text-align:right;">{{ number_format($data->generator_fuel,2,".",",") }} <?php $total_dr+=$data->generator_fuel ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->fire_pump_fuel))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Fire Pump Fuel</td>
				<td style="text-align:right;">{{ number_format($data->fire_pump_fuel,2,".",",") }} <?php $total_dr+=$data->fire_pump_fuel ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->toilet_stationary))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Toilet Stationary</td>
				<td style="text-align:right;">{{ number_format($data->toilet_stationary,2,".",",") }} <?php $total_dr+=$data->toilet_stationary ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->cleaning_equipment_meterials))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Cleaning Equipment Meterials</td>
				<td style="text-align:right;">{{ number_format($data->cleaning_equipment_meterials,2,".",",") }} <?php $total_dr+=$data->cleaning_equipment_meterials ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->transport_bill))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Transport Bill</td>
				<td style="text-align:right;">{{ number_format($data->transport_bill,2,".",",") }} <?php $total_dr+=$data->transport_bill ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->water_reservoir_clean))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Water Reservoir Clean</td>
				<td style="text-align:right;">{{ number_format($data->water_reservoir_clean,2,".",",") }} <?php $total_dr+=$data->water_reservoir_clean ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->ip_camera_maintenance))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">IP Camera Maintenance</td>
				<td style="text-align:right;">{{ number_format($data->ip_camera_maintenance,2,".",",") }} <?php $total_dr+=$data->ip_camera_maintenance ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->fire_hydrant))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Fire Hydrant</td>
				<td style="text-align:right;">{{ number_format($data->fire_hydrant,2,".",",") }} <?php $total_dr+=$data->fire_hydrant ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->carrying_bill))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Carrying Bill</td>
				<td style="text-align:right;">{{ number_format($data->carrying_bill,2,".",",") }} <?php $total_dr+=$data->carrying_bill ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->exhaust_fan))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Exhaust Fan</td>
				<td style="text-align:right;">{{ number_format($data->exhaust_fan,2,".",",") }} <?php $total_dr+=$data->exhaust_fan ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->led_light))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">LED Light</td>
				<td style="text-align:right;">{{ number_format($data->led_light,2,".",",") }} <?php $total_dr+=$data->led_light ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->fire_extinguisher))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Fire Extinguisher</td>
				<td style="text-align:right;">{{ number_format($data->fire_extinguisher,2,".",",") }} <?php $total_dr+=$data->fire_extinguisher ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->miscellaneous))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Miscellaneous</td>
				<td style="text-align:right;">{{ number_format($data->miscellaneous,2,".",",") }} <?php $total_dr+=$data->miscellaneous ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->generator_maintenance))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Generator Maintenance</td>
				<td style="text-align:right;">{{ number_format($data->generator_maintenance,2,".",",") }} <?php $total_dr+=$data->generator_maintenance ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->lift_maintenance))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Lift Maintenance</td>
				<td style="text-align:right;">{{ number_format($data->lift_maintenance,2,".",",") }} <?php $total_dr+=$data->lift_maintenance ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->ac_maintenance))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">AC Maintenance</td>
				<td style="text-align:right;">{{ number_format($data->ac_maintenance,2,".",",") }} <?php $total_dr+=$data->ac_maintenance ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->epoxy_maintenance))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Epoxy Maintenance</td>
				<td style="text-align:right;">{{ number_format($data->epoxy_maintenance,2,".",",") }} <?php $total_dr+=$data->epoxy_maintenance ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->water_pump_maintenance))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Water Pump Maintenance</td>
				<td style="text-align:right;">{{ number_format($data->water_pump_maintenance,2,".",",") }} <?php $total_dr+=$data->water_pump_maintenance ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->electrical_work))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Electrical Work</td>
				<td style="text-align:right;">{{ number_format($data->electrical_work,2,".",",") }} <?php $total_dr+=$data->electrical_work ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->wooden_work))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Wooden Work</td>
				<td style="text-align:right;">{{ number_format($data->wooden_work,2,".",",") }} <?php $total_dr+=$data->wooden_work ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->glass_work))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Glass Work</td>
				<td style="text-align:right;">{{ number_format($data->glass_work,2,".",",") }} <?php $total_dr+=$data->glass_work ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->metal_work))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Metal Work</td>
				<td style="text-align:right;">{{ number_format($data->metal_work,2,".",",") }} <?php $total_dr+=$data->metal_work ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->plumbing_work))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Plumbing Work</td>
				<td style="text-align:right;">{{ number_format($data->plumbing_work,2,".",",") }} <?php $total_dr+=$data->plumbing_work ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->tiles_work))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Tiles Work</td>
				<td style="text-align:right;">{{ number_format($data->tiles_work,2,".",",") }} <?php $total_dr+=$data->tiles_work ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->civil_work))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Civil Work</td>
				<td style="text-align:right;">{{ number_format($data->civil_work,2,".",",") }} <?php $total_dr+=$data->civil_work ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->fair_face_treatment))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Fair Face Treatment</td>
				<td style="text-align:right;">{{ number_format($data->fair_face_treatment,2,".",",") }} <?php $total_dr+=$data->fair_face_treatment ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->miscellaneous_maintenance))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Miscellaneous Maintenance</td>
				<td style="text-align:right;">{{ number_format($data->miscellaneous_maintenance,2,".",",") }} <?php $total_dr+=$data->miscellaneous_maintenance ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->signage))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Signage</td>
				<td style="text-align:right;">{{ number_format($data->signage,2,".",",") }} <?php $total_dr+=$data->signage ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->garden_maintenance))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Garden Maintenance</td>
				<td style="text-align:right;">{{ number_format($data->garden_maintenance,2,".",",") }} <?php $total_dr+=$data->garden_maintenance ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
			@if(isset($data->bank_charge))
			<tr>
                <td>{{ $sl++ }}</td>
				<td style="text-align:left;">Bank Charge</td>
				<td style="text-align:right;">{{ number_format($data->bank_charge,2,".",",") }} <?php $total_dr+=$data->bank_charge ; ?> </td>
				<td style="text-align:right;"></td>
            </tr>
			@endif
		@endforeach
			<tr>
				<th colspan="2">Total</th>
				<th style="text-align:right;">{{ number_format($total_dr,2,".",",") }}</th>
				<th style="text-align:right;"> {{ number_format($total_cr,2,".",",") }}</th>
			</tr>
				@endif	
        </tbody>
    </table>
</div>