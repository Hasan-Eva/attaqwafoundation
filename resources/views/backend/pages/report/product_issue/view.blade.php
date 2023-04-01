@extends('backend.layouts.master')
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">

				<div class="col-md-12 small mb-0">
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#voucherviewModal"><i class='fa fa-list'></i> Issued (View)</button></label>
                    </div>
					<!-- Start Voucher PDF Modal -->
						<div class="modal fade" id="voucherviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-ml" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Issued View</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="search_form" action="{{ route('issue_report.issue') }}" method="POST" id="editForm">
									{{ csrf_field() }}
									<div class="modal-body">
										<div class="col-sm-6 float-left">
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">From Date:</label>
												<input type="date" name="f_date" class="form-control" id="f_date" value="{{ date('Y-m-d') }}" >
											</div>
										</div>
										<div class="col-sm-6 float-left">
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">To Date:</label>
												<input type="date" name="t_date" class="form-control" id="t_date" value="{{ date('Y-m-d') }}" >
											</div>
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
					<!-- End Voucher PDF Modal -->
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-success btn-xs" data-toggle="modal" data-target="#voucherpdfModal"><i class='fas fa-file-pdf'></i> Issued (PDF)</button></label>
                    </div>
					<!-- Start Voucher PDF Modal -->
						<div class="modal fade" id="voucherpdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Issued PDF</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="{{ route('issue_report.pdf') }}" method="POST" target="_blank">
									{{ csrf_field() }}
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
					<!-- End Voucher PDF Modal -->
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal"><i class="fa fa-list"></i> Product Wise View</button></label>
                    </div>
					<!-- Ledger View Modal -->
					<div class="modal fade" id="myModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-ml" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Product Issued (View)</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="search_form" action="{{ route('ledger.data') }}" method="POST" id="editForm">
							@csrf
						  <div class="modal-body">
							<div class="col-sm-6 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">From Date:</label>
									<input type="date" name="f_date" class="form-control" id="f_date" value="{{ date('Y-m-d') }}" >
								</div>
							</div>
							<div class="col-sm-6 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">To Date:</label>
									<input type="date" name="t_date" class="form-control" id="t_date" value="{{ date('Y-m-d') }}" >
								</div>
							</div>
							<div class="col-sm-12 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label"> A/c Head:</label>
									<select class="form-control select2" name="h_name" style="width: 100%;" required>
										<option value="">Select Ledger Head</option>
										<?php 
											use App\Models\Category;
											$categories = Category::get(); 
										?>
										@foreach($categories as $row)
										<option value="{{ $row->id }} ">{{ $row->category_name }}</option>
										@endforeach
									 </select>
								</div>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary btn-sm">View Report</button>
						  </div>
						  </form>
						</div>
					  </div>
					</div>
					<!-- End Ledger View Modal -->
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#ledgerpdfModal"><i class='fas fa-file-pdf'></i> Product Wise PDF</button></label>
                    </div>
					<!-- Start Ledger PDF Modal -->
					<div class="modal fade" id="ledgerpdfModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-ml" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Product Wise (PDF)</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="search_form" action="{{ route('ledger.pdf') }}" method="POST" id="editForm" target="_blank">
							@csrf
						  <div class="modal-body">
							<div class="col-sm-6 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">From Date:</label>
									<input type="date" name="f_date" class="form-control" id="f_date" value="{{ date('Y-m-d') }}" >
								</div>
							</div>
							<div class="col-sm-6 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">To Date:</label>
									<input type="date" name="t_date" class="form-control" id="t_date" value="{{ date('Y-m-d') }}" >
								</div>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary btn-sm">View Report</button>
						  </div>
						  </form>
						</div>
					  </div>
					</div>
					<!-- End Ledger PDF Modal -->
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-success btn-xs" data-toggle="modal" data-target="#tbviewModal"><i class='fa fa-list'></i> Sub-Category Wise (View)</button></label>
                    </div>
					<!-- Start TB Modal -->
						<div class="modal fade" id="tbviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Sub-Category Wise (View)</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="search_form" action="{{ route('trailbalance.view') }}" method="POST" id="editForm">
									{{ csrf_field() }}
									<div class="modal-body">
										<div class="form-group">
											<label for="recipient-name" class="col-form-label">From</label>
											<input type="date" name="f_date" class="form-control" value="{{ date('Y-m-d') }}">
										</div>
										<div class="form-group">
											<label for="recipient-name" class="col-form-label">To</label>
											<input type="date" name="t_date" class="form-control" value="{{ date('Y-m-d') }}">
										</div>
										<div class="col-sm-12 float-left">
											<div class="form-group">
												<label for="recipient-name" class="col-form-label"> A/c Head:</label>
												<select class="form-control select2" name="h_name" style="width: 100%;" required>
													<option value="">Select Ledger Head</option>
													@foreach($categories as $row)
													<option value="{{ $row->id }} ">{{ $row->category_name }}</option>
													@endforeach
												 </select>
											</div>
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
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#tbpdfModal"><i class='fas fa-file-pdf'></i> Sub-Category Wise (PDF)</button></label>
                    </div>
					
					<!-- Start TB Modal -->
						<div class="modal fade" id="tbpdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Sub-Category Wise (PDF)</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="search_form" action="#" method="POST" id="editForm">
									{{ csrf_field() }}
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
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#bsviewModal"><i class='fa fa-list'></i> Category Wise (View)</button></label>
                    </div>
					<!-- Start TB Modal -->
						<div class="modal fade" id="bsviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Category Wise (View)</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="search_form" action="{{ route('balancesheet.view') }}" method="POST" id="editForm">
									{{ csrf_field() }}
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
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-success btn-xs" data-toggle="modal" data-target="#bspdfModal"><i class='fas fa-file-pdf'></i> Category Wise (PDF)</button></label>
                    </div>
					<!-- Start TB Modal -->
						<div class="modal fade" id="bspdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Category Wise (View)</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="search_form" action="#" method="POST" id="editForm">
									{{ csrf_field() }}
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
				</div>
              <!-- /.card-header -->
              <div class="card-body">

               	@if(isset($purchase))
					@include('backend.pages.report.product_issue.body.purchase_view') 
				@endif
				
				@if(isset($voucher))
					@include('backend.pages.accounts.body.voucher') 
				@endif
				
				@if(isset($trailbalance))
					@include('backend.pages.accounts.body.trail_balance') 
				@endif
				
				@if(isset($balancesheet))
					@include('backend.pages.accounts.body.balance_sheet') 
				@endif
				
		  	</div>
	    </div>
      </div>
	</div>
  </div>

</section>

@endsection