
<div class="col-sm-12 float-left">
	<h4>{{ $staffs->work_name }}</h4>
</div>

<form id="search_form" action="{{ route('routine_work.update') }}" method="POST" enctype="multipart/form-data">
		@csrf
      <div class="modal-body">
	  	<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Monthly Servicing Date:</small>
				<input type="hidden" name="id" value="{{ $staffs->id }}" >
				<input type="date" name="monthly_service_date" class="form-control" id="monthly_service_date" value="{{ $staffs->monthly_service_date }}" required>
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Quarterly Servicing Date:</small>
				<input type="date" name="quarterly_service_date" class="form-control" id="quarterly_service_date" value="{{ $staffs->quarterly_service_date }}" >
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Half Yearly Servicing Date:</small>
				<input type="date" name="halfyearly_service_date" class="form-control" id="halfyearly_service_date" value="{{ $staffs->halfyearly_service_date }}" >
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Yearly Servicing Date:</small>
				<input type="date" name="yearly_service_date" class="form-control" id="yearly_service_date" value="{{ $staffs->yearly_service_date }}" >
			</div>
		</div>
	</div>	
	<div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Update</button>
    </div>
</form>