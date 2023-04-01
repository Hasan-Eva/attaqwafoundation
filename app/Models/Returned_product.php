<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Returned_product extends Model
{
    use HasFactory;
	
	public function customer_order_detail()
    {
		return $this->belongsTo(Customer_order_detail::class);	
	}
	public function stock()
    {
		return $this->belongsTo(Stock::class);	
	}
}
