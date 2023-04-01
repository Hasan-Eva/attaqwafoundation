<?php  
use App\Models\Upazila;
use App\Models\Location;
use App\Models\Designation;
use App\Models\Department;
use App\Models\Shift;
use App\Models\Blood_group;
	$upazilas = Upazila::get();
	$locations = Location::orderBy('id', 'DESC')->get();
	$designations = Designation::whereIn('id',[6,8,11,14,15,17,19,20,21,24])->get();
	$departments = Department::orderBy('id', 'ASC')->get();
	$shifts = Shift::get();
	$blood_groups = Blood_group::get();
?>
<form id="search_form" action="{{ route('employee.staff.update') }}" method="POST" enctype="multipart/form-data">
		@csrf
      <div class="modal-body">
	  	<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Staff's Name:</small>
				<input type="hidden" name="id" value="{{ $staffs->id }}" >
				<input type="text" name="name" class="form-control" id="name" placeholder="Name of the Client" value="{{ $staffs->name }}" required>
			</div>
			<div class="form-group">
				<small>Mobile Number 1:</small>
				<input type="text" name="phone_1" class="form-control" id="phone_1" value="{{ $staffs->phone_1 }}"  />
			</div>
			<div class="form-group">
				<small>Present Address:</small>
				<input type="text" name="present_address" class="form-control" id="present_address" value="{{ $staffs->present_address }}" />
			</div>
			<div class="form-group">
				<small>Date of Joining:</small>
				<input type="date" name="joining_date" class="form-control" id="joining_date" value="{{ $staffs->joining_date }}" />
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Father's Name:</small>
				<input type="text" name="father_name" class="form-control" id="father_name" value="{{ $staffs->father_name }}">
			</div>
			<div class="form-group">
				<small>Mobile Number 2:</small>
				<input type="text" name="phone_2" class="form-control" id="phone_2" value="{{ $staffs->phone_2 }}"  />
			</div>
			<div class="form-group">
				<small>Parmanent Address:</small>
				<input type="text" name="permanent_address" class="form-control" id="permanent_address" value="{{ $staffs->permanent_address }}"/>
			</div>
			<div class="form-group">
				<small>Designation :</small>
				<select class="form-control select2" name="designation_id" style="width: 100%;" required>
                    <option value="">Select Designation</option>
                    @foreach($designations as $row)
					<option value="{{ $row->id }}"{{($row->id == $staffs->designation_id)?"Selected":'' }}>{{ $row->designation_name }}</option>
                    @endforeach
                 </select>
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Mother's Name :</small>
				<input type="text" name="mother_name" class="form-control" id="mother_name" value="{{ $staffs->mother_name }}">
			</div>
			<div class="form-group">
				<small>Email Address:</small>
				<input type="text" name="email" class="form-control" id="email" value="{{ $staffs->email }}" />
			</div>
			<div class="form-group">
				<small>NID Number:</small>
				<input type="text" name="nid" class="form-control" id="nid" value="{{ $staffs->nid }}"/>
			</div>
			<div class="form-group">
				<small>Blood Group :</small>
				<select class="form-control select2" name="blood_group" style="width: 100%;" >
					@foreach($blood_groups as $row)
					<option value="{{ $row->blood_group_name }}"{{($row->blood_group_name == $staffs->blood_group)?"Selected":'' }}>{{ $row->blood_group_name }}</option>
                    @endforeach
                 </select>
			</div>
		</div>
		<div class="col-sm-3 float-left">
			<div class="form-group">
				<small>Spouse Name:</small>
				<input type="text" name="spouse_name" class="form-control" id="spouse" value="{{ $staffs->spouse_name }}">
			</div>
			<div class="form-group">
				<small>Emergency Contact:</small>
				<input type="text" name="emergency_contact" class="form-control" id="emergency_contact" value="{{ $staffs->emergency_contact }}" />
			</div>
			<div class="form-group">
				<small>Date of Birth:</small>
				<input type="date" name="date_of_birth" class="form-control" id="date_of_birth" value="{{ $staffs->date_of_birth }}" required/>
			</div>
		</div>
      </div>
<div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Update</button>
</div>
</form>