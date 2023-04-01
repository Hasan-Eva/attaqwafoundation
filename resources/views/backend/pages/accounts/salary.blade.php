@extends('backend.layouts.master')
@section('content')
<?php 
use App\Courier_br; 
use App\Models\Company_info;
use App\Models\Advance_staff;
use App\Models\Absent_staff;
use App\Models\Advance_cleaner;
use App\Models\Absent_cleaner;
use App\Models\Advance_guard;
use App\Models\Absent_guard;

$f=date("Y-m-01", strtotime($month));
$t=date("Y-m-t", strtotime($month));
?>
<section class="content">
	<div class="container-fluid">
        <div class="row">
          	<div class="col-12">
				<div class="card">
				<form method="post" action="{{route('journal_salary.store')}}" id="myForm">
				@csrf
				<input type="hidden" name="t_date" value="{{ $t_date }}" />
				<input type="hidden" name="month" value="{{ $month }}" />
				<table class="table table-bordered table-striped table-hover ytable table-sm">
					<thead>
						<tr>
							<th colspan="9" style="text-align:center;">{{  date("F, Y", strtotime($month)) }} </th>
						</tr>
						<tr>
							<th>SL</th>
							<th>Name </th>
							<th>Designation</th>
							<th>Joining Date</th>
							<th style="text-align:center;">Salary</th>
							<th style="text-align:center;">Mobile Bill</th>
							<th style="text-align:center;">Advance</th>
							<th style="text-align:center;">Absent</th>
							<th style="text-align:center;">Total</th>
						</tr>
					</thead>
					<tbody>
						@php $total=0; $total_salary=0; $total_mobile_bill=0; $total_advance=0; $total_absent=0; @endphp
						@foreach($staffs as $data)
						@php $mobile_bill=0; $advance_ind=0; $absent_ind=0; @endphp
						<?php 
							$month_days = intval(date('t', strtotime($t))); // for days of the month
								$absent= Absent_staff::where('emp_id',$data->id)->whereBetween('date',[$f,$t])->first();
								if(isset($absent->total_absent)){ 
									$days = intval(date('t', strtotime($absent->date))); 
									$salary=($data->total_salary / $days) * ( $absent->total_absent );
								} else { 
									$salary=0; 
								}
								$advances= Advance_staff::where('emp_id',$data->id)->where('balance', '>', '0')->whereBetween('date',[$f,$t])->first();
								if(isset($advances->balance)){								
									$advance= $advances->balance ;
								} else { 
									$advance=0; 
								}
						?>
						<tr>
							<input type="hidden" name="id[]" value="{{ $data->id }}" />
							<input type="hidden" name="mobile[]" value="{{ $data->mobile_bill }}" />
							<input type="hidden" name="designation_id[]" value="{{ $data->designation_id }}" />
							<td>{{ $loop->iteration }}</td>
							<td>{{ $data->name }}</td>
							<td>{{ $data->designation_name }}</td>
							<td style="text-align:center;">{{  date("d.m.Y", strtotime($data->joining_date)) }}</td>
							<td style="text-align:right; padding:3px;"><?php echo number_format($data->total_salary,0,".",","); $total_salary+=$data->total_salary; ?></td>
							<td style="text-align:right; padding:3px;">
								<?php if($data->mobile_bill>0) { echo number_format($data->mobile_bill,0,".",","); $mobile_bill+=$data->mobile_bill; $total_mobile_bill+=$data->mobile_bill;} else {$mobile_bill+=0; $total_mobile_bill+=0; }?>
							</td>
							<td style="text-align:right;">
								<?php if($advance>0) { echo number_format($advance,0,".",","); $total_advance+=$advance; $advance_ind+=$advance;} else {$total_advance+=0; $advance_ind+=0;}?>
								<input type="hidden" name="advance[]" value="{{ $advance }}" />
							</td>
							<td style="text-align:right;">
								<?php if(isset($absent->total_absent)){echo number_format($salary,0); $total_absent+=$salary ; $absent_ind+=$salary ; } else {$total_absent+=0; $absent_ind+=0 ;}?>
								<input type="hidden" name="absent[]" value="{{ $salary }}" />
							</td>
							<td style="text-align:right; padding:3px;"> 
							<!--
							<?php if($data->joining_date>$f) { $monthlysalary=round(($data->total_salary / $month_days) * ((strtotime($t) - strtotime($data->joining_date))/ 86400 + 1)); } else { $monthlysalary=$data->total_salary ; }  ?>
							-->
							{{ number_format($monthlysalary,0,".",",") }} 
								<input type="hidden" name="amount[]" value="{{ $monthlysalary }}" />
								<input type="text" name="total_salary[]" value="{{ round($monthlysalary + $mobile_bill - $advance_ind - $absent_ind) }}" style="width:70px; text-align:right;" />
								<?php $total+=$monthlysalary + $mobile_bill - $advance_ind - $absent_ind ; ?>
							</td>
						</tr>
						@endforeach	 
					</tbody>
					<tfoot>
						<tr>
							<th colspan="4" class="text-center"> Total</th>
							<th style="text-align:right; padding:3px;">{{ number_format($total_salary,0,".",",") }}</th>
							<th style="text-align:right; padding:3px;">{{ number_format($total_mobile_bill,0,".",",") }}</th>
							<th style="text-align:right; padding:3px;">{{ number_format($total_advance,0,".",",") }}</th>
							<th style="text-align:right; padding:3px;">{{ number_format($total_absent,0,".",",") }}</th>
							<th style="text-align:right; padding:3px;">{{ number_format($total,0,".",",") }}</th>
						</tr>
					</tfoot>
				</table>
				<div class="col-md-2" style="float:right;">
					<button type="submit" class="form-control form-control-md btn btn-primary" id="storeButton" onClick="return confirm('Are you sure, you want to Save the Data?');">Submit</button>
				</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
