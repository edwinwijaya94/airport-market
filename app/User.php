<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// class User extends Authenticatable
class User extends Model
{
    protected $connection = 'pgsql_2';

    // use Notifiable;
    // public $table = "users";

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array
    //  */
    // protected $fillable = [
    //     'username', 'password',
    // ];

    // /**
    //  * The attributes that should be hidden for arrays.
    //  *
    //  * @var array
    //  */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
}
