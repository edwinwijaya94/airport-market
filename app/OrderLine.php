<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    public $table = "order_lines";

    public function order() {
    	return $this->belongsTo('App\Order', 'order_id');
    }

    public function product() {
    	return $this->belongsTo('App\Product', 'product_id');
    }

    public function unit() {
    	return $this->belongsTo('App\Unit', 'unit_id');
    }
}
