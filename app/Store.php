<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public $table = "stores";
    
    public function products() {
    	return $this->hasMany('App\Product')->orderBy('name', 'ASC');
    }
}
