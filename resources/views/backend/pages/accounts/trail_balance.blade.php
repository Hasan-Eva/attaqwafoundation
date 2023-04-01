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
			<form action="{{ route('trail_balance_data') }}" method="post">
			@csrf
			From : <input type="date" name="f_date" value="{{ date('Y-m-d') }}" />
			To : <input type="date" name="t_date" value="{{ date('Y-m-d') }}" />
			<button name="submit" value="Submit">Submit</button>
			</form>
		</div>
		</div>
            <div class="card-body">
                	<?php $f_date=request()->input('f_date'); $t_date=request()->input('t_date'); 
					?>
                   <table>
                       <thead>
					   		<tr>
								<th colspan="4" style="border:none; text-align:center;">Trail Balance</th>
							</tr>
							<tr>
								
								<td colspan="4" style="border:none; text-align:center;">{{ date("F d,Y", strtotime($f_date)) }} to {{ date("F d,Y", strtotime($t_date)) }}</td>
								
							</tr>
                           <tr>
                              <th>SL</th>
                              <th style="width:250px;">Particulars</th>
							  <th width="20%">Debit</th>
							  <th width="20%">Credit</th>
                            </tr>
                        </thead>
                        
                        <tbody>
				@if(isset($dr))
						@php $total_dr=0; $total_cr=0; $sl=1; @endphp
						@foreach($dr as $data)
							@if(isset($data->capital_dr) OR isset($data->capital_cr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Capital A/c</td>
							    <td style="text-align:right;">@if($data->capital_dr - $data->capital_cr>0){{ number_format($data->capital_dr - $data->capital_cr,2,".",",") }} @endif</td>
							   <td style="text-align:right;">@if($data->capital_dr - $data->capital_cr<=0){{ number_format($data->capital_cr - $data->capital_dr,2,".",",") }} @endif</td>
                            </tr>
							@endif
							@if(isset($data->cash_dr) OR isset($data->cash_cr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Cash A/c</td>
							    <td style="text-align:right;">@if($data->cash_dr - $data->cash_cr>0){{ number_format($data->cash_dr - $data->cash_cr,2,".",",") }} @endif</td>
							   <td style="text-align:right;">@if($data->cash_dr - $data->cash_cr<=0){{ number_format($data->cash_cr - $data->cash_dr,2,".",",") }} @endif</td>
                            </tr>
							@endif
							@if(isset($data->bank_dr) OR isset($data->bank_cr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Bank A/c</td>
							    <td style="text-align:right;">@if($data->bank_dr - $data->bank_cr>0){{ number_format($data->bank_dr - $data->bank_cr,2,".",",") }} @endif</td>
							   <td style="text-align:right;">@if($data->bank_dr - $data->bank_cr<=0){{ number_format($data->bank_cr - $data->bank_dr,2,".",",") }} @endif</td>
                            </tr>
							@endif	
							@if(isset($data->bkash_dr) OR isset($data->bkash_cr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">bKash A/c</td>
							    <td style="text-align:right;">@if($data->bkash_dr - $data->bkash_cr>0){{ number_format($data->bkash_dr - $data->bkash_cr,2,".",",") }} @endif</td>
							   <td style="text-align:right;">@if($data->bkash_dr - $data->bkash_cr<=0){{ number_format($data->bkash_cr - $data->bkash_dr,2,".",",") }} @endif</td>
                            </tr>
							@endif
							@if(isset($data->rocket_dr) OR isset($data->rocket_cr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Rocket A/c</td>
							    <td style="text-align:right;">@if($data->rocket_dr - $data->rocket_cr>0){{ number_format($data->rocket_dr - $data->rocket_cr,2,".",",") }} @endif</td>
							   <td style="text-align:right;">@if($data->rocket_dr - $data->rocket_cr<=0){{ number_format($data->rocket_cr - $data->rocket_dr,2,".",",") }} @endif</td>
                            </tr>
							@endif	
							@if(isset($data->nagoth_dr) OR isset($data->nagoth_cr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Nagoth A/c</td>
							    <td style="text-align:right;">@if($data->nagoth_dr - $data->nagoth_cr>0){{ number_format($data->nagoth_dr - $data->nagoth_cr,2,".",",") }} @endif</td>
							   <td style="text-align:right;">@if($data->nagoth_dr - $data->nagoth_cr<=0){{ number_format($data->nagoth_cr - $data->nagoth_dr,2,".",",") }} @endif</td>
                            </tr>
							@endif
							@if(isset($data->receivable_dr) OR isset($data->receivable_cr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Receivable A/c</td>
							    <td style="text-align:right;">@if($data->receivable_dr - $data->receivable_cr>0){{ number_format($data->receivable_dr - $data->receivable_cr,2,".",",") }} @endif</td>
							   <td style="text-align:right;">@if($data->receivable_dr - $data->receivable_cr<=0){{ number_format($data->receivable_cr - $data->receivable_dr,2,".",",") }} @endif</td>
                            </tr>
							@endif
							@if(isset($data->purchase_dr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Purchase A/c</td>
							    <td style="text-align:right;">@if($data->purchase_dr>0){{ number_format($data->purchase_dr,2,".",",") }} @endif</td>
							   <td style="text-align:right;"></td>
                            </tr>
							@endif
							@if(isset($data->sales_dr) OR isset($data->sales_cr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Sales A/c</td>
							    <td style="text-align:right;">@if($data->sales_dr - $data->sales_cr>0){{ number_format($data->sales_dr - $data->sales_cr,2,".",",") }} @endif</td>
							   <td style="text-align:right;">@if($data->sales_dr - $data->sales_cr<=0){{ number_format($data->sales_cr - $data->sales_dr,2,".",",") }} @endif</td>
                            </tr>
							@endif
							
							@if(isset($data->salary_dr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Salary A/c</td>
							   <td style="text-align:right;">@if($data->salary_dr>0){{ number_format($data->salary_dr,2,".",",") }} @endif</td>
							   <td style="text-align:right;"></td>
                            </tr>
							@endif	
							@if(isset($data->houserent_dr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">House Rent A/c</td>
							   <td style="text-align:right;">@if($data->houserent_dr>0){{ number_format($data->houserent_dr,2,".",",") }} @endif</td>
							   <td style="text-align:right;"></td>
                            </tr>
							@endif
							@if(isset($data->entertainment_dr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Entertainment A/c</td>
							   <td style="text-align:right;">@if($data->entertainment_dr>0){{ number_format($data->entertainment_dr,2,".",",") }} @endif</td>
							   <td style="text-align:right;"></td>
                            </tr>
							@endif
							@if(isset($data->electricity_dr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Electricity A/c</td>
							   <td style="text-align:right;">@if($data->electricity_dr>0){{ number_format($data->electricity_dr,2,".",",") }} @endif</td>
							   <td style="text-align:right;"></td>
                            </tr>
							@endif
							@if(isset($data->conveyance_dr))
							<tr>
                               <td>{{ $sl++ }}</td>
							   <td style="text-align:left;">Conveyance A/c</td>
							   <td style="text-align:right;">@if($data->conveyance_dr>0){{ number_format($data->conveyance_dr,2,".",",") }} @endif</td>
							   <td style="text-align:right;"></td>
                            </tr>
							@endif
						@endforeach
						
					
							<tr>
								<th colspan="2">Total</th>
								<th style="text-align:right;"></th>
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