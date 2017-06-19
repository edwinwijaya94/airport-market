<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function addUser(Request $request) {
        //add order to database
    	$user = new User();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->password = $request->password;
        $user->save();

        return "Selamat Anda sudah terdaftar di Fresh Market";
    }
}
