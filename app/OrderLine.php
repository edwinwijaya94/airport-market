<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    public $table = "order_lines";

    public function product() {
    	return $this->hasOne('App\Product');
    }

    public function order() {
    	return $this->hasOne('App\Order');
    }
}
