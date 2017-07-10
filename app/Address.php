<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $table = "adresses";

    public function address() {
    	return $this->belongsTo('App\User');
    }
}