<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_order_detail extends Model
{
    use HasFactory;
	public function stock()
    {
		return $this->belongsTo(Stock::class);	
	}
}
