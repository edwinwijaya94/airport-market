<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $connection = 'pgsql_2';
    protected $table = "roles";
}
