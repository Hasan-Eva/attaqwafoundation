@extends('backend.layouts.master')
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Salary Journal List <button class="small float-right btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus-circle"></i> Add New</button></h4>
									
									</div>
              <!-- /.card-header -->
              <div class="card-body">
               	<table class="table table-bordered table-striped table-hover ytable table-sm">
                  <thead>
					  <tr>
						<th>SL</th>
						<th>Date</th>
						<th>Ac Head</th>
						<th>Dr. Amount</th>
						<th>Ac Head</th>
						<th>Cr. Amount</th>
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
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title btn btn-success" id="exampleModalLabel">Salary Month</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	   <form id="search_form" action="{{ route('journal_salary_1.view') }}" method="POST" id="editForm">
		@csrf
      <div class="modal-body">
			<div class="col-sm-12 float-left">
				<div class="form-group">
					<label for="recipient-name" class="col-form-label">Salary Month:</label>
         @php $previous_period=date("Y-m-t", strtotime(date('Y-m-d'). ' - 1 month')); @endphp
					<input type="date" name="month" class="form-control" id="month" value="{{ $previous_period }}" >
				</div>
			</div>
			<div class="col-sm-12 float-left">
				<div class="form-group">
					<label for="recipient-name" class="col-form-label">Journal Date:</label>
					<input type="date" name="t_date" class="form-control" id="t_date" value="{{ date('Y-m-d') }}" >
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary btn-sm">Show</button>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Client Information</h5>
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
        ajax: "{{ route('journal_salary.view') }}",
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
 <script> 
  $('body').on('click','.edit', function(){
  		let id=$(this).data('id');
		$.get("admin/client/edit/"+id, function(data){
			$("#modal_body").html(data);
		)};
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


