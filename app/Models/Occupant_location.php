<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Occupant_location extends Model
{
    use HasFactory;
	public function occupant()
    {
		return $this->belongsTo(Occupant::class);	
	}
	public function location()
    {
		return $this->belongsTo(Location::class);	
	}
}
