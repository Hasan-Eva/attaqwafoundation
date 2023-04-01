@extends('backend.layouts.master')
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Journal List <button class="small float-right btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> Add New</button></h4>
									
									</div>
              <!-- /.card-header -->
              <div class="card-body">
               	<table class="table table-bordered table-striped table-hover ytable table-sm">
                  <thead>
					  <tr>
						<th style="width:5px;">SL</th>
						<th style="width:50px;">Date</th>
						<th>Ac Head</th>
						<th>Dr. </th>
						<th>Ac Head</th>
						<th>Cr. </th>
						<th>Particulars</th>
						<th>Action</th>
					  </tr>
                  </thead>
                  <tbody>
                 
				  </tbody>
				</table>
		  	</div>
	    </div>
      </div>
	</div>
  </div>


<!-- Modal -->
<div class="modal fade" id="myModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title btn btn-success" id="exampleModalLabel">Journal Entry Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	   <form id="search_form" action="{{ route('journal.store') }}" method="POST" id="editForm">
		@csrf
      <div class="modal-body">
	  	<div class="col-sm-3 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Date:</label>
				<input type="date" name="j_date" class="form-control" id="j_date" value="{{ date('Y-m-d') }}" >
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Transaction With:</label>
				<input type="text" name="transactionwith" class="form-control" id="transactionwith" value="" autoComplete="on">
			</div>
		</div>
		<div class="col-sm-4 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Particulars:</label>
				<input type="text" name="particulars" class="form-control" id="particulars" value="" >
			</div>
		</div>
		<div class="col-sm-2 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Ref No:</label>
				<input type="text" name="ref_no" class="form-control" id="ref_no" value="" >
			</div>
		</div>
		<div class="col-sm-8 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Dr A/c Head:</label>
				<select class="form-control select2" name="dr_head_1" style="width: 100%;" required>
					<option value="">Actual Ac Head</option>
                    @foreach($dr_heads as $row)
					<option value="{{ $row->id }} ">{{ $row->h_name }}</option>
                    @endforeach
                 </select>
			</div>
			<div class="form-group">
				<label for="recipient-name" class="col-form-label">Cr A/c Head:</label>
				<select class="form-control select2" name="cr_head_1" style="width: 100%;" required>
					<option value="">Actual Ac Head</option>
                    @foreach($cr_heads as $row)
					<option value="{{ $row->id }} ">{{ $row->h_name }}</option>
                    @endforeach
                 </select>
			</div>
		</div>
		<div class="col-sm-2 float-left">
			<div class="form-group">
				<label for="recipient-name" class="col-form-label" style="width:100px; text-align:left;">Dr Amount</label>
				<input type="text" name="dr_cash_1" class="form-control text-right" id="dr_cash_1" value="" required>
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
				<input type="text" name="cr_cash_1" class="form-control text-right" id="cr_cash_1" value="" required>
				<input type="hidden" name="cr_cash_2" class="form-control" id="" value="" >
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm" onClick="return confirm('Are you sure, you want to Save the Data?');">Save Data</button>
      </div>
	  </form>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="editModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Journal Edit  Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  	<div id="modal_body">
		
		</div>
	   
    </div>
  </div>
</div>
</section>

@endsection



<script src="{{ asset('public/backend') }}/plugins/datatables/jquery.js"></script>

<script>
  $(function () {
    
    var table = $('.ytable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('journal.view') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
			{data: 'j_date', name: 'j_date'},
            {data: 'dr', name: 'dr'},
			{data: 'amount', name: 'amount'},
			{data: 'cr', name: 'cr'},
			{data: 'amount', name: 'amount'},
			{data: 'particulars', name: 'particulars'},
			{
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
  });
 </script>
 <script type="text/javascript">
	$(function(){
		$(document).on('click','.edit',function(){
			
			var id = $(this).data('id');
			//alert(id);
			$.get("editjournal/"+id, function(data){
				 $('#modal_body').html(data);
			});
			
		});
	});
</script>
<script>
$(document).ready(function(){
	 $("#dr_cash_1").change(function(){
	 	var amount =  $("#dr_cash_1").val();
		$('#cr_cash_1').val(amount);
	  });
	 $("#cr_cash_1").change(function(){
	 	var amount =  $("#cr_cash_1").val();
		$('#dr_cash_1').val(amount);
	  });
  });
</script>


