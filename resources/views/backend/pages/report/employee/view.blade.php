@extends('backend.layouts.master')
@section('content')

<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">

				<div class="col-md-12 small mb-0">
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#voucherviewModal"><i class='fa fa-list'></i> All (View)</button></label>
                    </div>
					<!-- Start Voucher PDF Modal -->
						<div class="modal fade" id="voucherviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">All View</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="search_form" action="{{ route('staff_report.all_view') }}" method="POST" id="editForm">
									{{ csrf_field() }}
									<div class="modal-body">
										<div class="form-group">
											<label for="recipient-name" class="col-form-label">As On</label>
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
						<button type="submit" class="btn btn-success btn-xs" data-toggle="modal" data-target="#voucherpdfModal"><i class='fas fa-file-pdf'></i> All (PDF)</button></label>
                    </div>
					<!-- Start Voucher PDF Modal -->
						<div class="modal fade" id="voucherpdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">All PDF</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form action="{{ route('staff_report.all_pdf') }}" method="POST" target="_blank">
									{{ csrf_field() }}
									<div class="modal-body">
										<div class="form-group">
											<label for="recipient-name" class="col-form-label">As On</label>
											<input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}">
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
					
					
					<!-- Start Salary View Modal -->
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#ledgerpdfModal"><i class='fas fa-file-pdf'></i> Salary Generate PDF</button></label>
                    </div>
					<!-- Start Ledger PDF Modal -->
					<div class="modal fade" id="ledgerpdfModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-sm" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Salary Generate (PDF)</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="search_form" action="{{ route('staff_report.salary_pdf') }}" method="POST" id="editForm" target="_blank">
							@csrf
						  <div class="modal-body">
							<div class="col-sm-12 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">As on:</label>
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
						<button type="submit" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#salaryvoucherpdfModal"><i class='fas fa-file-pdf'></i> Salary Voucher (PDF)</button></label>
                    </div>
					
					<!-- Start TB Modal -->
						<div class="modal fade" id="salaryvoucherpdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Salary Voucher (PDF)</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="search_form" action="{{ route('staff_report.salary_voucher_pdf') }}" method="POST" id="editForm" target="_blank">
									{{ csrf_field() }}
									<div class="modal-body">
										<div class="col-sm-12 float-left">
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">As on:</label>
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
					<!-- End Modal -->
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#bonuspdfModal"><i class='fas fa-file-pdf'></i> Bonus Generate (PDF)</button></label>
                    </div>
					
					<!-- Start TB Modal -->
						<div class="modal fade" id="bonuspdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Bonus Generate (PDF)</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="search_form" action="{{ route('staff_report.bonus_pdf') }}" method="POST" id="editForm" target="_blank">
									{{ csrf_field() }}
									<div class="modal-body">
										<div class="col-sm-12 float-left">
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">As on:</label>
												<input type="date" name="t_date" class="form-control" id="t_date" value="{{ date('Y-m-d') }}" >
											</div>
										</div>
										<div class="col-sm-12 float-left">
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">Bonus For:</label>
												<select name="bonus_name" class="form-control select2" id="bonus_name" required>
													<option value="">Please Select </option>
													<option value="Eid-ul Fitar">Eid-ul Fitar </option>
													<option value="Eid-ul Azha">Eid-ul Azha </option>
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
						<button type="submit" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#bonusvoucherpdfModal"><i class='fas fa-file-pdf'></i> Bonus Voucher (PDF)</button></label>
                    </div>
					
					<!-- Start TB Modal -->
						<div class="modal fade" id="bonusvoucherpdfModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog modal-sm" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h6 class="modal-title" id="exampleModalLabel" style="color:#00CC00;">Bonus Voucher (PDF)</h6> <span style="padding-left:10px; color: #000066;"> </span>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<form id="search_form" action="{{ route('staff_report.bonus_voucher_pdf') }}" method="POST" id="editForm" target="_blank">
									{{ csrf_field() }}
									<div class="modal-body">
										<div class="col-sm-12 float-left">
											<div class="form-group">
												<label for="recipient-name" class="col-form-label">As on:</label>
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
					<!-- End Modal -->
					
					<div style="float:left; padding-left:10px;">
						<button type="submit" class="btn btn-success btn-xs" data-toggle="modal" data-target="#absentguardModal"><i class='fa fa-list'></i> Absent Guards</button></label>
                    </div>
					<!-- Ledger View Modal -->
					<div class="modal fade" id="absentguardModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-ml" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Absent ( Guards )</h5>
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
									<label for="recipient-name" class="col-form-label"> Name:</label>
									<select class="form-control select2" name="h_name" style="width: 100%;" required>
										<option value="">Select Ledger Head</option>
										<?php 
											use App\Models\Guard;
											$names = Guard::get(); 
										?>
										@foreach($names as $row)
										<option value="{{ $row->id }} ">{{ $row->name }}</option>
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
						<button type="submit" class="btn btn-success btn-xs" data-toggle="modal" data-target="#absentModal"><i class='fa fa-list'></i> Absent Cleaner</button></label>
                    </div>
					<!-- Ledger View Modal -->
					<div class="modal fade" id="absentModal" style="overflow:hidden;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog modal-ml" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Absent Input Form( Cleaners )</h5>
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
									<input type="date" name="f_date" class="form-control" id="f_date" required >
								</div>
							</div>
							<div class="col-sm-6 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">To Date:</label>
									<input type="date" name="t_date" class="form-control" id="t_date" required >
								</div>
							</div>
							<div class="col-sm-8 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label"> Name:</label>
									<select class="form-control select2" name="emp_id" style="width: 100%;" required>
										<option value="">Select Cleaner Name</option>
										<?php 
											use App\Models\Cleaner;
											use App\Models\Absent_cleaner;
											$names = Cleaner::get(); 
											$absents = Absent_cleaner::get(); 
										?>
										@foreach($names as $row)
										<option value="{{ $row->id }} ">{{ $row->name }}</option>
										@endforeach
									 </select>
								</div>
							</div>
							<div class="col-sm-4 float-left">
								<div class="form-group">
									<label for="recipient-name" class="col-form-label">Total Absent Day(s):</label>
									<input type="number" name="total_absent" class="form-control" id="total_absent" required >
								</div>
							</div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary btn-sm">Submit</button>
						  </div>
						  </form>
						  
						</div>
					  </div>
					</div>
					<!-- End Ledger View Modal -->
					
				</div>
              <!-- /.card-header -->
              <div class="card-body">

               	@if(isset($staffs))
					@include('backend.pages.report.employee.body.all_view') 
				@endif
				
				@if(isset($voucher))
					@include('backend.pages.accounts.body.voucher') 
				@endif
				
				
				
		  	</div>
	    </div>
      </div>
	</div>
  </div>

</section>

@endsection