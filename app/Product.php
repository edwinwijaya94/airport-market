<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = "products";

    public function unit() {
    	return $this->belongsTo('App\Unit', 'default_unit_id');
    }
}