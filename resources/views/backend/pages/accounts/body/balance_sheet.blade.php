<?php 
use App\Models\Company_info;
?>
<style>
	table, th, td {
	border:1px solid #CCCCCC; 
	}
	table, th {
	text-align:center; 
	}
</style>
	<div class="card mb-4">
		
            <div class="card-body">
			@if(isset($balancesheet))
						@php $total_dr=0; $total_cr=0; $sl=1; @endphp
						
                	<?php $f_date=request()->input('f_date'); $t_date=request()->input('t_date'); 
							$previous_period=date("Y-m-d", strtotime($t_date. ' - 1 month'));
					?>
                   <table>
                       <thead>
					   		<tr>
								<th colspan="4" style="border:none; text-align:center;">{{ Company_info::first()->name }}</th>
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
								<td>{{ date("F d,Y", strtotime($previous_period)) }}</td>
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
							@foreach($balancesheet as $data)
							<?php 	$a1=$data->cash_dr - $data->cash_cr;
									$a2=$data->bank_dr - $data->bank_cr;
							?>
							<tr>
                               <th style="border:none; text-align:left;">Cash & Bank</th>
							   <td style="border:none;"></td>
							   <th style="border:none; text-align:right;"></th>
							   <th style="border:none; text-align:right;">{{ number_format($a1+$a2,2,".",",") }}</th>
                            </tr>
							
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Cash In Hand</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;"></td>
							   <td style=" border-bottom-color:#FFFFFF;  text-align:right;">{{ number_format($data->cash_dr - $data->cash_cr,2,".",",") }}</td>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Balance With Bank</td>
							   <td style="border:none;"></td>
							   <td style="text-align:right;"></td>
							   <td style="text-align:right;">{{ number_format($data->bank_dr - $data->bank_cr,2,".",",") }}</td>
                            </tr>
							@endforeach
							<tr>
                               <th style="border:none; text-align:left;">Accounts Receivable</th>
							   <td style="border:none;"></td>
							   <th style="border:none; text-align:right;"></th>
							   <td style="border:none; text-align:right;"></td>
                            </tr>
							
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">XXXXXXXXXXXXXX</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;"></td>
							   <td style=" border-bottom-color:#FFFFFF;"></td>
                            </tr>
							
							@foreach($balancesheet as $data)
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Others</td>
							   <td style="border:none;"></td>
							   <td style="text-align:right;"></td>
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
							
							
							<tr>
								<th colspan="2" style="text-align:left; padding-left:20px;">Total Assets</th>
								<th style="text-align:right;"></th>
								<th style="text-align:right;">{{ number_format($a1+$a2,2,".",",") }} </th>
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
							   <th style="border:none; text-align:right;"></th>
							   <th style="border:none; text-align:right;">{{ number_format($data->capital_cr - $data->capital_dr - $data->bank_charge,2,".",",") }}</th>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Shareholder's Equity</td>
							   <td style="border:none;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;"></td>
							   <td style=" border-bottom-color:#FFFFFF; text-align:right;">{{ number_format($data->capital_cr - $data->capital_dr,2,".",",") }}</td>
                            </tr>
							<tr>
                               <td style="border:none; text-align:left; padding-left:10px;">Bank Profit/Charge</td>
							   <td style="border:none;"></td>
							   <td style="text-align:right;"></td>
							   <td style="text-align:right;">-{{ number_format($data->bank_charge,2,".",",") }}</td>
                            </tr>
							<tr>
								<th colspan="2" style="text-align:left; padding-left:20px;">Total Liabilities & Owner's Equity</th>
								<th style="text-align:right;"></th>
								<th style="text-align:right;"> {{ number_format($data->capital_cr - $data->capital_dr - $data->bank_charge,2,".",",") }}</th>
							</tr>
				@endif	
                         </tbody>
                     </table>
                 </div>
          
         </div>	   
	</div>