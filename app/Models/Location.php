<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
	public function occupantss()
    {
		return $this->hasMany(Occupant_location::class, 'location_id', 'id');
	}
}
