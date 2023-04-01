<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
	 public function product()
    {
		return $this->belongsTo(Product::class);	
	}
	public function brand()
    {
		return $this->belongsTo(Brand::class);	
	}
	public function color()
    {
		return $this->belongsTo(Color::class);	
	}
	public function size()
    {
		return $this->belongsTo(Size::class);	
	}
}
