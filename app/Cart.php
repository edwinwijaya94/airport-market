<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public $table = "carts";

    public function product() {
    	return $this->belongsTo('App\Product', 'product_id');
    }

}