<div class="col-md-12 float-left">
 <div class="form-group col-md-6 float-left">
	<table>
		<tr>
			<th>{{ $staffs->name }} </th>
			<th rowspan="4" style=" padding-left:20px;">
				<img src="{{ asset('public/images/cleaner/'. $staffs->image) }}" class="img-circle elevation-2" alt="Card image" width="50px;" /> 
			</th>
		</tr>
		<tr>
			<td>{{ $staff_file->designation->designation_name }}</td>
			<td style="width:30px;"></td>
			<td rowspan="2">
			<form id="search_form" action="{{ route('personal_file.cleaner_file_update') }}" method="POST" enctype="multipart/form-data">
			@csrf
				<input type="hidden" name="staff_file_id" value="{{ $staff_file->id }}" />	
			<select name="location_id" id="location_id" class="form-control form-control-sm select2" style="font-size:14px; height:30px;" required>
					@foreach($locations as $row)
					<option value="{{ $row->id }}"{{($row->id == $staff_file->location_id)?"Selected":'' }}>{{ $row->location_name }}</option>
					@endforeach
				</select>
				<button type="submit" class="form-control btn btn-success btn-xs" onClick="return confirm('Are you sure, you want to Save the Data?');">Update</button>
			</form>
			</td>
		</tr>
		<tr>
			<td>{{ $staff_file->location->location_name }}</td>
		</tr>
	</table>
 </div>
</div>


<form id="search_form" action="{{ route('personal_file.cleaner_file_store') }}" method="POST" enctype="multipart/form-data">
@csrf
<div class="col-md-12 float-left">
 	<div class="form-group col-md-2 float-left">
    <label for="recipient-name" class="col-form-label">Date:</label>
			<input type="hidden" name="id" id="id" value="{{ $staffs->id }}">
            <input type="date" class="form-control form-control-sm " name="execution_date" id="execution_date" style="font-size:14px; height:30px;" value="{{date('Y-m-d')}}">
    </div>
	<div class="form-group col-md-2 float-left">
       	<label for="recipient-name" class="col-form-label">Type:</label>
		<select name="type" id="type" class="form-control form-control-sm select2" style="font-size:14px; height:30px;" required>
					<option value="" >Select Type</option>
					<option value="Confirm" >Confirm</option>
					<option value="Increment" >Increment</option>
					<option value="Special Increment" >Special Increment</option>
					<option value="Transfer" >Transfer</option>
					<option value="Released" >Released</option>
		</select>
    </div>
	<div class="form-group col-md-3 float-left">
            <label for="recipient-name" class="col-form-label">Designation:</label>
			<select name="designation_id" id="designation_id" class="form-control form-control-sm select2" style="font-size:14px; height:30px;" required>
				@foreach($designations as $row)
				<option value="{{ $row->id }}"{{($row->id == $staff_file->designation_id)?"Selected":'' }}>{{ $row->designation_name }}</option>
				@endforeach
			</select>
    </div>
	<div class="form-group col-md-3 float-left">
       	<label for="recipient-name" class="col-form-label">Job Type:</label>
		<select class="form-control select2" name="jobtype" style="width: 100%;" required>
          	<option value="">Select</option>
			<option value="Probationary" {{($staff_file->jobtype == "Probationary")?"Selected":'' }}>Probationary</option>
			<option value="Confirm" {{($staff_file->jobtype == "Confirm")?"Selected":'' }}>Confirm</option>
            <option value="Contactual" {{($staff_file->jobtype == "Contactual")?"Selected":'' }}>Contactual</option>
			<option value="Outsourceing" {{($staff_file->jobtype == "Outsourceing")?"Selected":'' }}>Outsourceing</option>
       	</select>
    </div>
	<div class="form-group col-md-2 float-left">
            <label for="recipient-name" class="col-form-label">Job Location:</label>
			<select name="location_id" id="location_id" class="form-control form-control-sm select2" style="font-size:14px; height:30px;" required>
				@foreach($locations as $row)
				<option value="{{ $row->id }}"{{($row->id == $staff_file->location_id)?"Selected":'' }}>{{ $row->location_name }}</option>
				@endforeach
			</select>
	</div>
</div>
<div class="col-md-12 float-left">
	<div class="form-group col-md-4 float-left">
            <label for="recipient-name" class="col-form-label">Department:</label>
			<select name="department_id" id="department_id" class="form-control form-control-sm select2" style="font-size:14px; height:30px;" required>
				@foreach($departments as $row)
				<option value="{{ $row->id }}"{{($row->id == $staff_file->department_id)?"Selected":'' }}>{{ $row->department_name }}</option>
				@endforeach
			</select>
    </div>
	<div class="form-group col-md-4 float-left">
			<label for="recipient-name" class="col-form-label">Duty Shift:</label>
			<select name="shift_id" id="shift_id" class="form-control form-control-sm select2" style="font-size:14px; height:30px;" required>
				@foreach($shifts as $row)
				<option value="{{ $row->id }}"{{($row->id == $staff_file->shift_id)?"Selected":'' }}>{{ $row->period }}</option>
				@endforeach	
			</select>
    </div>
	<div class="form-group col-md-2 float-left">
            <label for="recipient-name" class="col-form-label">Salary:</label>
			<input type="text" class="form-control form-control-sm text-right" name="total_salary" id="total_salary" style="font-size:14px; height:30px;" value="{{ $staff_file->total_salary }}" required>
    </div>
	<div class="form-group col-md-1 float-left">
			<label for="recipient-name" class="col-form-label">Close:</label>
			<button type="button" class="form-control btn btn-primary" data-dismiss="modal">Close</button>
    </div>
	<div class="form-group col-md-1 float-left">
			<label for="recipient-name" class="col-form-label">Save:</label>
   			<button type="submit" class="form-control btn btn-success" onClick="return confirm('Are you sure, you want to Save the Data?');">Save</button>
    </div>
</div>
</form>
<!-- Table Row Data -->

<div class="col-md-12 float-left">
 <div class="form-group col-md-12 float-left">
	<table id="example1" class=" table-bordered table-striped hover" width="100%">
		<tr>
            <th style="text-align:center;">SL</th>
            <th style="text-align:center;">Date</th>
			<th style="text-align:center;">Type</th>
			<th style="text-align:center;">Designation</th>
			<th style="text-align:center;">Department</th>
			<th style="text-align:center;">Location</th>
			<th style="text-align:center;">Shift</th>
			<th style="text-align:center;">Salary</th>
		</tr>
		@foreach($pf as $row)
		<tr>
			 <td>{{ $loop->iteration }}</td>
			<td>{{  date("d.m.Y", strtotime($row->execution_date)) }}</td>
			<td style="text-align:center;">{{ $row->type }}</td>
			<td style="text-align:center;">{{ $row->designation->designation_name }}</td>
			<td style="text-align:center;">{{ $row->department->department_name }}</td>
			<td style="text-align:center;">{{ $row->location->location_name }}</td>
			<td style="text-align:center;">{{ $row->shift->period }}</td>
			<td style="text-align:center;">{{ number_format($row->total_salary,0) }}</td>
		</tr>
		@endforeach
	</table>
 </div>
</div>

<script>
$('.select2').each(function() { 
    $(this).select2({ dropdownParent: $(this).parent()});
})
</script>