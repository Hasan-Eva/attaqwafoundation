@extends('backend.layouts.master')
@section('content')

<style>
table tr th{
	text-align:center;
	font-style:italic;
}
.head{
	width:250px;
	border:none;
	
}
</style>
<div style="width:1000px; background-color:#FFFFFF; padding-left:10px;">
	
	<form class="form-horizontal" method="POST" action="{{ route('journal.store') }}" enctype="multipart/form-data">
	@csrf
		<table class="table">
			<tr><th colspan="6" style="color:#00CC33;" >Journal Entry Form</th></tr>
			<tr><th colspan="1" style="color:#00CC33;" >Date: <input type="date" name="j_date" value="{{ date('Y-m-d') }}" /></th>
				<th></th>
				<th colspan="2" style="color:#00CC33;" >Particulars: <input type="text" name="particulars" value=""/></th>
			</tr>
			<tr>
				<th>A/c Head</th><th style="max-width:100px; text-align:left;">Dr. Amount</th><th style="text-align:left;">Cr. Amount</th><th>AD Row</th>
			</tr>
			<tr>
				<td><select name="dr_head_1" class="head form-control form-control-sm select2" required><option value=""></option>
					@php
						$query="SELECT * FROM ac_heads WHERE role IN(0,1,3)";
						$data=DB::select($query);
						@endphp
						@foreach($data as $row)
						<option value="{{ $row->id }}">{{ $row->h_name }}</option>
					@endforeach
					</select>
				</td>
				<td><input type="number" name="dr_cash_1" id="dr_cash_1" style="width:100px; border:1px solid #CCCCCC; text-align:right;" /></td>			
				<td></td>
				<th>
				<input type="checkbox" id="ad_dr_row" name="vehicle1" value="AD">
				</th>
			</tr>
			<tr class="ad_dr" style="display:none;">
				<td><select name="dr_head_2" class="head form-control form-control-sm select2" ><option value="" style=""></option>
						@foreach($data as $row)
						<option value="{{ $row->id }}">{{ $row->h_name }}</option>
						@endforeach
					</select>
				</td>
				<td><input type="number" name="dr_cash_2" style="width:100px; border:1px solid #CCCCCC; text-align:right;"  /></td>			
				<td></td>
				
			</tr>
			<tr>
				
			</tr>
			<tr>
				<td colspan="2" style="padding-left:50px;"><select name="cr_head_1" class="head form-control form-control-sm select2" required><option value=""></option>
					@php
						$query="SELECT * FROM ac_heads WHERE role IN(1,2)";
						$data=DB::select($query);
					@endphp
						@foreach($data as $row)
						<option value="{{ $row->id }}">{{ $row->h_name }}</option>
						@endforeach
					</select>
				</td>
				<td><input type="number" name="cr_cash_1" id="cr_cash_1" style="width:100px; border:1px solid #CCCCCC; text-align:right;"  /></td>			
				<th>
				<input type="checkbox" id="ad_cr_row" name="vehicle1" value="AD">
				</th>
			</tr>
			<tr class="ad_cr" style="display:none;">
				<td colspan="2" style="padding-left:50px;"><select name="cr_head_2" class="head form-control form-control-sm select2" ><option value=""></option>
						@foreach($data as $row)
						<option value="{{ $row->id }}">{{ $row->h_name }}</option>
					@endforeach
					</select>
				</td>
				<td><input type="number" name="cr_cash_2" style="width:100px; border:1px solid #CCCCCC; text-align:right;" /></td>					
			</tr>
			<tr>
				<td colspan="4"><button type="submit" class="btn btn-info" >Add Journal</button></td>
			</tr>
		</table>
	</form>
	
</div>


	
<script src="{{ asset('public/backend') }}/plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	 $('#ad_dr_row[type="checkbox"]').click(function(){
	 if($(this).is(":checked")){
                $(".ad_dr").show();
            }
           else if($(this).is(":not(:checked)")){
                $(".ad_dr").hide();
            }
	 });
	 
	 $('#ad_cr_row[type="checkbox"]').click(function(){
	 if($(this).is(":checked")){
                $(".ad_cr").show();
            }
           else if($(this).is(":not(:checked)")){
                $(".ad_cr").hide();
            }
	 });
	 
	 $("#dr_cash_1").change(function(){
	 	var amount =  $("#dr_cash_1").val();
		$('#cr_cash_1').val(amount);
	  });
	 $("#dr_bank_1").change(function(){
	 	var amount =  $("#dr_bank_1").val();
		$('#cr_bank_1').val(amount);
	  });
  });
</script>

@endsection
