<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    public $table = "units";
    public $timestamps = false;

    public function products() {
    	return $this->hasMany('App\Product');
    }
}
