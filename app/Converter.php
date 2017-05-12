<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Converter extends Model
{
    public $table = "converters";

    public function unit() {
        return $this->belongsTo('App\Unit');
    }
}
