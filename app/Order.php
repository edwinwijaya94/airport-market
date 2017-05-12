<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = "orders";

    public function status() {
    	return $this->hasOne('App\OrderStatus');
    }

    public function buyer() {
    	return $this->hasOne('App\User');
    }

    public function shopper() {
    	return $this->hasOne('App\User');
    }
}
