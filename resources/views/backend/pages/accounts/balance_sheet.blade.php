@extends('admin.admin')
@section('content')
<style>
	table, th, td {
	border:1px solid #CCCCCC; 
	}
	table, th {
	text-align:center; 
	}
</style>
	<div class="card mb-4">
		<div class="card-header">
			<div class="card-header">
			<form action="{{ route('balance_sheet') }}" method="post">
			@csrf
					<input type="hidden" name="f_date" value="2020-10-01" />
			As On : <input type="date" name="t_date" value="{{ date('Y-m-d') }}" /> 
			
			<button name="submit" value="Submit">Submit</button>
			</form>
		</div>
		</div>
            <div class="card-body">
			@if(isset($dr))
						@php $total_dr=0; $total_cr=0; $sl=1; @endphp
						
                	<?php $t_date=request()->input('t_date'); ?>
                   <table>
                       <thead>
					   		<tr>
								<th colspan="4" style="border:none; text-align:center;">Jekhanei.com</th>
							</tr>
							<tr>
								<td colspan="4" style="border:none; text-align:center;"> Balance Sheet</td>
							</tr>
							<tr>
								<td colspan="4" style="border:none; text-align:center;">As on {{ date("F d,Y", strtotime($t_date)) }}</td>
							</tr>
                           <tr>
                              <th style="width:250px;" rowspan="2">Particulars</th>
							  <th width="5%" rowspan="2">Notes</th>
							  <th width="30%" colspan="2">Amount In Taka</th>
                            </tr>
							<tr>
								<td>{{ date("F d,Y", strtotime($t_date)) }}</td>
								<td>{{ date("F d,Y", strtotime($t_date)) }}</td>
							</tr>
                        </thead>
                        
                        <tbody>
							<tr>
                               <th style="border:none; text-align:left;"><u>PROPERTY AND ASSETS</u></th>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
                            </tr>
							@foreach($dr as $data)
							<?php 	$a1=$data->cash_dr - $data->cash_cr;
									$a2=$data->bank_dr - $data->bank_cr;
									$a3=$data->bkash_dr - $data->bkash_cr;
									$a4=$data->rocket_dr - $data->rocket_cr;
									$a5=$data->nagoth_dr - $data->nagoth_cr;
									$a6=$data->receivable_dr - $data->receivable_cr;
							?>
							<tr>
                               <th style="border:none; text-align:left;">Cash</th>
							   <td style="border:none;"></td>
							   <th style="border:none; text-align:right;">{{ number_format($a1+$a2+$a3+$a4+$a5,2,".",",") }}</th>
							   <td style="border:none;"></td>
                            </tr>
							
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Cash In Hand</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($data->cash_dr - $data->cash_cr,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF;  text-align:right;"></td>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Balance With Bank</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF;  text-align:right;">{{ number_format($data->bank_dr - $data->bank_cr,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF;  text-align:right;"></td>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Balance With bKash</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($data->bkash_dr - $data->bkash_cr,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;"></td>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Balance With Rocket</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($data->rocket_dr - $data->rocket_cr,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;"></td>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Balance With Nagad</td>
							   <td style="border:none;"></td>
							   <td style="text-align:right;">{{ number_format($data->nagoth_dr - $data->nagoth_cr,2,".",",") }}</td>
							   <td style="text-align:right;"></td>
                            </tr>
							@endforeach
							@foreach($totals as $total)
							<tr>
                               <th style="border:none; text-align:left;">Accounts Receivable</th>
							   <td style="border:none;"></td>
							   <th style="border:none; text-align:right;">{{ number_format($a6+$total->totalprice-$total->avdance +$total->courier_charge,2,".",",") }}</th>
							   <td style="border:none; text-align:right;"></td>
                            </tr>
							@endforeach
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Ali2bd Supplier</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;"></td>
							   <td style=" border-bottom-color:#FFFFFF;"></td>
                            </tr>
							
							@foreach($pathaos as $pathao)
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Patho Courier Service</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($pathao->totalprice - $pathao->avdance + $pathao->courier_charge,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF;"></td>
                            </tr>
							@endforeach
							@foreach($sundarbans as $sundarban)
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Sundarban Courier Service</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($sundarban->totalprice - $sundarban->avdance + $sundarban->courier_charge,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF;"></td>
                            </tr>
							@endforeach
							@foreach($saps as $sap)
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">S A Paribahan Courier Service</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($sap->totalprice - $sap->avdance + $sap->courier_charge,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF;"></td>
                            </tr>
							@endforeach
							@foreach($jananis as $janani)
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Janani Courier Service</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($janani->totalprice - $janani->avdance + $janani->courier_charge,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF;"></td>
                            </tr>
							@endforeach
							@foreach($koratoas as $koratoa)
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Korotoa Courier Service</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($koratoa->totalprice - $koratoa->avdance + $koratoa->courier_charge,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF;"></td>
                            </tr>
							@endforeach
							@foreach($dr as $data)
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Others</td>
							   <td style="border:none;"></td>
							   <td style="text-align:right;">{{ number_format($data->receivable_dr - $data->receivable_cr,2,".",",") }}</td>
							   <td style="text-align:right;"></td>
                            </tr>
							<tr>
                               <th style="border:none; text-align:left;">Prepaid Expenses</th>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
                            </tr>
							@endforeach
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">All Prepaid Expenses</td>
							   <td style="border:none;"></td>
							   <td></td>
							   <td></td>
                            </tr>
							<tr>
                               <th style="border:none; text-align:left;">Inventory</th>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
                            </tr>
							
							@foreach($stocks as $stock)
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Stock Inventory</td>
							   <td style="border:none;"></td>
							   <td style="text-align:right;">{{ number_format($stock->inventory,2,".",",") }} <?php $inventory=$stock->inventory; ?></td>
							   <td style="text-align:right;"></td>
                            </tr>
							@endforeach
							<tr>
								<th colspan="2" style="text-align:left; padding-left:20px;">Total Assets</th>
								<th style="text-align:right;">{{ number_format($a1+$a2+$a3+$a4+$a5+$a6+$total->totalprice-$total->avdance +$total->courier_charge + $inventory,2,".",",") }}<?php $total_asset=$a1+$a2+$a3+$a4+$a5+$a6+$total->totalprice-$total->avdance +$total->courier_charge + $inventory; ?></th>
								<th style="text-align:right;"> </th>
							</tr>
							
							<tr>
								<td colspan="4" style="height:10px;"></td>
							</tr>
							<tr>
                               <th style="border:none; text-align:left;"><u>LIABILITIES AND OWNERS EQUITY</u></th>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
                            </tr>
							<tr>
                               <th style="border:none; text-align:left;">Liabilities</th>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
							   <td style="border:none;"></td>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Accounts Payable</td>
							   <td style="border:none;"></td>
							   <td></td>
							   <td></td>
                            </tr>
							<tr>
                               <th style="border:none; text-align:left;">Owners Equity</th>
							   <td style="border:none;"></td>
							   <th style="border:none; text-align:right;">{{ number_format($total_asset,2,".",",") }}</th>
							   <td style="border:none;"></td>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Shareholder's Equity</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($data->capital_cr - $data->capital_dr,2,".",",") }}</td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;"></td>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Profit/Loss</td>
							   <td style="border:none;"></td>
							   <td style="text-align:right;">{{ number_format($total_asset- $data->capital_cr - $data->capital_dr,2,".",",") }}</td>
							   <td></td>
                            </tr>
							<tr>
								<th colspan="2" style="text-align:left; padding-left:20px;">Total Liabilities & Owner's Equity</th>
								<th style="text-align:right;">{{ number_format($total_asset,2,".",",") }}</th>
								<th style="text-align:right;"> </th>
							</tr>
				@endif	
                         </tbody>
                     </table>
                 </div>
          
         </div>	   
	</div>

@endsection

@section('scripts')
	<script>
		// Call the dataTables jQuery plugin
		$(document).ready(function() {
		  $('#dataTable').DataTable();
		});
	
	</script> 

@endsection

@include('admin.script')