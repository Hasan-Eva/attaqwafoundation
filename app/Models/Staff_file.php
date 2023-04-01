<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff_file extends Model
{
    use HasFactory;
	public function staff()
    {
		return $this->belongsTo(Staff::class);	
	}
	public function designation()
    {
		return $this->belongsTo(Designation::class);	
	}
	public function location()
    {
		return $this->belongsTo(Location::class);	
	}
	public function department()
    {
		return $this->belongsTo(Department::class);	
	}
	public function shift()
    {
		return $this->belongsTo(Shift::class);	
	}
}
