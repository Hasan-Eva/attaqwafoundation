<form method="post" action="{{route('subcategory.update')}}" id="myForm">
@csrf
<div style="height:110px; border: 1px solid #009966;">
	<div class="col-sm-12 float-left">
			<div class="form-group">
				<small>Sub Category Name:</small>
				<input type="hidden" name="id" id="id" value="{{ $subcategory->id }}">
				<input type="text" name="subcategory_name" class="form-control" id="subcategory_name" placeholder="Input New Sub-category Name" value="{{$subcategory->subcategory_name}}" required>
				<span class="text-danger">@error('subcategory_name'){{$message}}@enderror</span>
			</div>
			<div class="form-group">
				<small>Category Name:</small>
				<select class="form-control select2" name="category_id" style="width: 100%;" required>
					<option value="">Select Category</option>
                    @foreach($categories as $row)
					<option value="{{ $row->id }}" {{($row->id == $subcategory->category_id)?'selected':''}}>{{ $row->category_name }}</option>
                    @endforeach
                 </select>
				 <span class="text-danger">@error('category_id'){{$message}}@enderror</span>
			</div>
	</div>
</div>
<div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
    </div>
</form>