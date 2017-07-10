<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function addUser(Request $request) {
        //add order to database
    	$user = new User();
        $user->name = $request->customer_name;
        $user->address = $request->address;
        $user->phone_number = $request->phone_number;
        $user->username = $request->username;
        $user->save();

        return "Selamat Anda sudah terdaftar di Fresh Market";
    }
}
