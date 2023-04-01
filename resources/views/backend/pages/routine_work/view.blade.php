@extends('backend.layouts.master')
@section('content')

    <div class="card-body">
		@if(isset($routine_works))
            <table id="example1" class="table-bordered table-striped hover" with="100%">
                <thead>
					<tr>
						<th colspan="10" style="text-align:center;">@include('company.company')@include('company.company_address')</th>
					</tr>
					<tr>
						<th rowspan="2">SL</th>
						<th rowspan="2">Particulars</th>
						<th colspan="4" class="text-center">Servicing Date</th>
						<th rowspan="2">Agreement Date </th>
						<th rowspan="2">Service Charge </th>
						<th rowspan="2">Expire Date </th>
						<th rowspan="2">Action </th>
                    </tr>
					<tr>
						<th >Monthly</th>
						<th >Quarterly</th>
						<th >Halfyearly</th>
						<th >Yearly</th>
                    </tr>
                </thead>
                <tbody>
					<?php $date=date("Y-m-d");  $alert_15=date("Y-m-d", strtotime($date. ' + 15 day')); $alert_7=date("Y-m-d", strtotime($date. ' + 7 day')); ?>
					@foreach($routine_works as $data)
					<tr>
						<?php $monthly=date("Y-m-d", strtotime($data->monthly_service_date. ' + 1 Months'));  ?>
                        <td>{{ $loop->iteration }}</td>
						<td>{{ $data->work_name }} </td>
						@if($date >= $data->monthly_service_date AND $data->monthly_service_date != '')
						<td class="text-center" style="background-color:#FF0000;" title="{{ $data->monthly_fee }}">
						@elseif($alert_7 >= $data->monthly_service_date AND $data->monthly_service_date != '')
						<td class="text-center" style="background-color: #00FF00;" title="{{ $data->monthly_fee }}"> 
						@elseif($alert_15 >= $data->monthly_service_date AND $data->monthly_service_date != '')
						<td class="text-center" style="background-color: #00FF99;" title="{{ $data->monthly_fee }}"> 
						@else
						<td class="text-center" style="background-color:#FFFFFF;">
						@endif
						{{  ($data->monthly_service_date != '')? date("d.m.Y", strtotime($data->monthly_service_date)):''  }}</td>
						
						@if($date >= $data->quarterly_service_date AND $data->quarterly_service_date != '')
						<td class="text-center" style="background-color:#FF0000;" title="{{ $data->quarterly_fee }}">
						@elseif($alert_7 >= $data->quarterly_service_date AND $data->quarterly_service_date != '')
						<td class="text-center" style="background-color: #00FF00;" title="{{ $data->quarterly_fee }}"> 
						@elseif($alert_15 >= $data->quarterly_service_date AND $data->quarterly_service_date != '')
						<td class="text-center" style="background-color: #00FF99;" title="{{ $data->quarterly_fee }}"> 
						@else
						<td class="text-center" style="background-color:#FFFFFF;">
						@endif
						{{  ($data->quarterly_service_date != '')? date("d.m.Y", strtotime($data->quarterly_service_date)):''  }}</td>
						
						@if($date >= $data->halfyearly_service_date AND $data->halfyearly_service_date != '')
						<td class="text-center" style="background-color:#FF0000;" title="{{ $data->halfyearly_fee }}">
						@elseif($alert_7 >= $data->halfyearly_service_date AND $data->halfyearly_service_date != '')
						<td class="text-center" style="background-color: #00FF00;" title="{{ $data->halfyearly_fee }}"> 
						@elseif($alert_15 >= $data->halfyearly_service_date AND $data->halfyearly_service_date != '')
						<td class="text-center" style="background-color: #00FF99;" title="{{ $data->halfyearly_fee }}"> 
						@else
						<td class="text-center" style="background-color:#FFFFFF;">
						@endif
						{{  ($data->halfyearly_service_date != '')? date("d.m.Y", strtotime($data->halfyearly_service_date)):''  }}</td>
						
						@if($date >= $data->yearly_service_date AND $data->yearly_service_date != '')
						<td class="text-center" style="background-color:#FF0000;" title="{{ $data->yearly_fee }}">
						@elseif($alert_7 >= $data->yearly_service_date AND $data->yearly_service_date != '')
						<td class="text-center" style="background-color: #00FF00;" title="{{ $data->yearly_fee }}"> 
						@elseif($alert_15 >= $data->yearly_service_date AND $data->yearly_service_date != '')
						<td class="text-center" style="background-color: #00FF99;" title="{{ $data->yearly_fee }}"> 
						@else
						<td class="text-center" style="background-color:#FFFFFF;">
						@endif
						{{  ($data->yearly_service_date != '')? date("d.m.Y", strtotime($data->yearly_service_date)):''  }}</td>
						
						<td style="text-align:center;">{{ date("d.m.Y", strtotime($data->contact_date)) }} </td>
						<td style="text-align:center;">{{ number_format($data->monthly_fee,0) }} </td>
						
						@if($date >= $data->contact_expire_date AND $data->contact_expire_date != '')
						<td class="text-center" style="background-color:#FF0000;">
						@elseif($alert_7 >= $data->contact_expire_date AND $data->contact_expire_date != '')
						<td class="text-center" style="background-color: #00FF00;"> 
						@elseif($alert_15 >= $data->contact_expire_date AND $data->contact_expire_date != '')
						<td class="text-center" style="background-color: #00FF99;"> 
						@else
						<td class="text-center" style="background-color:#FFFFFF;">
						@endif
						{{  ($data->contact_expire_date != '')? date("d.m.Y", strtotime($data->contact_expire_date)):''  }}</td>
						
						<td class="text-center">
							<button type="button" class="btn btn-success btn-xs edit" id="{{ $data->id }}" data-id="{{ $data->id }}" data-toggle="modal" data-target="#EditModal"><i class="fas fa-edit"> Update </i></button> 
						</td>	  
                    </tr>
					@endforeach
                </tbody>
            </table>
		@endif
    </div>

<!-- Edit Modal -->
<div class="modal fade" id="EditModal" role="dialog" data-backdrop="false" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog cascading-modal modal-avatar modal-lg" role="document">
    <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
				<h5 class="modal-title btn btn-warning" id="exampleModalLabel">Update Severcing Date</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
            <!-- Modal body -->
          	<div id="modal_body">
                     
          	</div>
      </div>
   </div>
</div>
<!-- / Edit Modal -->


@endsection

<script src="{{ asset('public/backend') }}/plugins/datatables/jquery.js"></script>
<script type="text/javascript">
	$(function(){
		$(document).on('click','.edit',function(){
			var id = $(this).data('id');
			//alert(id);
			$.get("editworkroutine/"+id, function(data){
				 $('#modal_body').html(data);
			});
			
		});
	});
</script>