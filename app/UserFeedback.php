<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFeedback extends Model
{
    public $table = "user_feedbacks";

    public function reasons() {
    	// return $this->hasMany('App\User');
    }
}
