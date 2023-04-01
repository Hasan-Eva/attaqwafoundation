<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;
	public function ac_head()
    {
		return $this->belongsTo(Ac_head::class);	
	}
}
