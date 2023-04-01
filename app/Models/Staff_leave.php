<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff_leave extends Model
{
    use HasFactory;
	public function staff()
    {
		return $this->belongsTo(Staff::class);	
	}
	public function leave_type()
    {
		return $this->belongsTo(Leave_type::class);	
	}
}
