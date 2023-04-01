<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invoice extends Model
{
    use HasFactory;
	public function customer_order()
    {
		return $this->belongsTo(Customer_order::class);	
	}
	public function customer_order_detail()
    {
		return $this->belongsTo(Customer_order_detail::class);	
	}
	public function courier_br()
    {
		return $this->belongsTo(Courier_br::class);	
	}
}
