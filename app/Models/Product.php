<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
	public function category()
    {
		return $this->belongsTo(Category::class);	
	}
	public function unit()
    {
		return $this->belongsTo(Unit::class);	
	}
	
	public function subcategory()
    {
		return $this->belongsTo(Subcategory::class);	
	}
	
	public function gender()
    {
		return $this->belongsTo(Gender::class);	
	}
}
