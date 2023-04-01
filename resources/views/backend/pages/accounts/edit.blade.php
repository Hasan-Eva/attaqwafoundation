<?php
use App\Models\Ac_head;
	$dr_heads = Ac_head::whereIn('role',[0,1])->get();
	$cr_heads = Ac_head::whereIn('role',[1,2])->get();
?>
      <form id="search_form" action="{{ route('journal.update') }}" method="POST" id="editForm">
		@csrf
      <div class="modal-body">
	  	<div class="col-sm-3 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Date:</label>
				<input type="hidden" name="id" class="form-control" id="id" value="{{ $journals->id }}" >
				<input type="date" name="j_date" class="form-control" id="j_date" value="{{ $journals->j_date }}" >
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Transaction With:</label>
				<input type="text" name="transactionwith" class="form-control" id="transactionwith" value="{{ $journals->transactionwith }}" autoComplete="on">
			</div>
		</div>
		<div class="col-sm-4 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Particulars:</label>
				<input type="text" name="particulars" class="form-control" id="particulars" value="{{ $journals->particulars }}" >
			</div>
		</div>
		<div class="col-sm-2 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Ref No:</label>
				<input type="text" name="ref_no" class="form-control" id="ref_no" value="{{ $journals->ref_no }}" >
			</div>
		</div>
		<div class="col-sm-8 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Dr A/c Head:</label>
				<select class="form-control select2" name="dr_head_1" id="dr_head" style="width: 100%;" required>
					<option value="">Actual Ac Head</option>
                    @foreach($dr_heads as $row)
					<option value="{{ $row->id }}" {{ ($row->id==$journals->dr_head)?"Selected":"" }}>{{ $row->h_name }}</option>
                    @endforeach
                 </select>
			</div>
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Cr A/c Head:</label>
				<select class="form-control select2" name="cr_head_1" id="cr_head" style="width: 100%;" required>
					<option value="">Actual Ac Head</option>
                    @foreach($cr_heads as $row)
					<option value="{{ $row->id }}" {{ ($row->id==$journals->cr_head)?"Selected":"" }}>{{ $row->h_name }}</option>
                    @endforeach
                 </select>
			</div>
		</div>
		<div class="col-sm-2 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label" style="width:100px; text-align:left;">Dr Amount</label>
				<input type="text" name="dr_cash_1" class="form-control text-right" id="dr_cash_2" value="{{ $journals->amount }}" required>
				<input type="hidden" name="dr_cash_2" class="form-control" id="" value="" >
			</div>
			<div class="form-group">
				<label for="recipient-name" class="col-form-label" style="width:100px; text-align:left;">Dr Amount</label>
				<input type="text" name="" class="form-control" id="" value="" disabled="disabled">
			</div>
		</div>
		<div class="col-sm-2 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label text-right" style="width:100px; text-align:right;">Cr Amount</label>
				<input type="text" name="" class="form-control" id="" value="" disabled="disabled">
			</div>
			<div class="form-group">
				<label for="recipient-name" class="col-form-label" style="width:100px; text-align:right;">Cr Amount</label>
				<input type="text" name="cr_cash_1" class="form-control text-right" id="cr_cash_2" value="{{ $journals->amount }}" required>
				<input type="hidden" name="cr_cash_2" class="form-control" id="" value="" >
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" onClick="return confirm('Are you sure, you want to Update the Data?');">Save Data</button>
      </div>
</form>

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
	});
</script>
<script>
$(document).ready(function(){
	 $("#dr_cash_2").change(function(){
	 	var amount =  $("#dr_cash_2").val();
		$('#cr_cash_2').val(amount);
	  });
	 $("#cr_cash_2").change(function(){
	 	var amount =  $("#cr_cash_2").val();
		$('#dr_cash_2').val(amount);
	  });
  });
</script>
