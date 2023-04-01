@extends('backend.layouts.master')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"><h4 class="text-left" style="color: #FF9900;"> Invoice List <button type="submit" class="btn btn-primary float-right btn-xs" data-toggle="modal" data-target="#allModal"><i class="fa fa-print"></i> Print All</button></h4>
									
			</div>
              <!-- /.card-header -->
              <div class="card-body">
               	<table id="example" class="table table-bordered table-striped table-hover ytable table-sm">
                  <thead>
					  <tr>
						<th width="5%">SL</th>
						<th width="15%">Date</th>
						<th width="20%">Customer Name</th>
						<th width="15%">Mobile</th>
						<th width="35%">Customer Address</th>
						<th width="10%">Action</th>
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


<!-- Start Modal -->
<div class="modal fade" id="allModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Invoice Print</h5> <span style="padding-left:10px; color: #000066;"> </span>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
			</div>
			<form id="search_form" action="{{ route('invoice.view_invoice_all') }}" target="_blank" method="POST" id="editForm">
			{{ csrf_field() }}
				<input type="hidden" name="id" id="id" value="" >
				<div class="modal-body">
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">From</label>
						<input type="date" name="f_date" class="form-control" value="{{ date('Y-m-d') }}">
					</div>
					<div class="form-group">
						<label for="recipient-name" class="col-form-label">To</label>
						<input type="date" name="t_date" class="form-control" value="{{ date('Y-m-d') }}">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary btn-sm"> Submit </button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End Modal -->

</section>

@endsection

<script src="{{ asset('public/backend') }}/plugins/datatables/jquery.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
    
		$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		});
	
		var table = $('.ytable').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('invoice.view') }}",
			columns: [
				{data: 'DT_RowIndex', name: 'DT_RowIndex'},
				{data: 'invoice_date', name: 'invoice_date'},
				{data: 'customer_name', name: 'customer_name'},
				{data: 'phone_1', name: 'phone_1'},
				{data: 'address_1', name: 'address_1'},
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
