<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = "orders";

    // public function status() {
    // 	return $this->hasOne('App\OrderStatus');
    // }

    public function buyer() {
    	return $this->hasOne('App\User');
    }

    public function store() {
        return $this->belongsTo('App\Store');
    }

    public function shopper() {
    	return $this->hasOne('App\Shopper');
    }

    public function orderline() {
        return $this->hasMany('App\Orderline');
    }

    public function user() {
        return $this->belongsTo('App\User', 'customer_id')->select('name', 'address', 'phone_number', 'address_note');
    }

    public function getUpdatedAtAttribute($date) {
        return Carbon::parse($date)->format('l, d F Y H:i');
    }

    public function status() {
        return $this->belongsTo('App\OrderStatus', 'order_status');
    }
}
