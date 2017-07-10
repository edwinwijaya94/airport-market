<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class UserController extends Controller
{

    public function getAllUser() {
        $user = User::all();

        return Response::json(array(
            'user'=>$user->toArray()),
            200
        );
    }

    public function getUserByID(Request $request) {
        $user = User::find($request->id);

        return Response::json(array(
            'user'=>$user->toArray()),
            200
        );

    }

    public function addUser(Request $request) {
        //add order to database
        $user = new User();
        $user->name = strtolower($request->name);
        $user->username = strtolower($request->username);
        $user->address = $request->address;
        $user->phone_number = $request->phone;
        $user->password = $request->password;
        $user->save();

        return "Selamat Anda sudah terdaftar di Fresh Market";
    }

    public function updateUser(Request $request) {
        //update order to database
        User::where('id', $request->id)
            ->update(array(
                        'name' => strtolower($request->name),
                        'address' => $request->address,
                        'phone_number' => $request->phone)
                    );

        return "Profile Anda berhasil diubah";
    }

    public function login(Request $request) {
        //get user from database
        $user = User::where([
                ['username', '=', strtolower($request->username)],
                ['password', '=', $request->password]
            ])->first();
        if($user != NULL) { // if user exsist
           return Response::json(array(
                'error'=>false,
                'user_id'=>$user->id),
                200
            );
        } else {
            return Response::json(array(
                'error'=>true,
                'message'=>"Anda belum terdaftar. Silahkan lakukan Registrasi")
            );
        }
    }
}
