<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Garendong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class UserController extends Controller
{

    public function userLogin(Request $request) {
        //get user from database
        $user = User::where('username', strtolower($request->username))->first();

        if($user != NULL) { //user exsist
            if ($request->password == $user->password) { //password true
                if ($user->fake < 3) { //not fake account
                    return Response::json(array(
                        'error'=>false,
                        'user_id'=>$user->id),
                        200
                    );        
                } else {
                    return Response::json(array(
                        'error'=>true,
                        'message'=>"Akun Anda sudah diblok")
                    );
                }
            } else { //password false
                return Response::json(array(
                    'error'=>true,
                    'message'=>"Password Anda Salah")
                );
            }            
        } else {
            return Response::json(array(
                'error'=>true,
                'message'=>"Anda belum terdaftar. Silahkan lakukan Registrasi")
            );
        }
    }

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

    public function getBuyerRoleID() {
        $role = Role::where('name', 'pembeli')->first();

        return $role->id;
    }

    public function addUser(Request $request) {
        //add order to database
        $user = new User();
        $user->role_id = self::getBuyerRoleID();
        $user->name = strtolower($request->name);
        $user->username = strtolower($request->username);
        $user->email = $request->email;
        $user->address = $request->address;
        $user->address_note = strtolower($request->address_note);
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
                        'address_note' => $request->addressNote,
                        'phone_number' => $request->phone)
                    );

        return "Profile Anda berhasil diubah";
    }

    public function addGarendong(Request $request) {
        //add order to database
        $user = new User();
        $user->name = strtolower($request->name);
        $user->role_id = 2;
        $user->username = strtolower($request->username);
        $user->address = $request->address;
        $user->phone_number = $request->phone;
        $user->password = $request->password;
        $user->save();

        $user = User::where('username', '=', strtolower($request->username))
                    ->first();
        var_dump($user->id);
        $garendong = new Garendong();
        $garendong->user_id = $user->id;
        $garendong->rating = 0;
        $garendong->num_rating = 0;
        $garendong->save();

        return "Selamat Anda sudah terdaftar di Fresh Market";
    }

    public function garendongLogin(Request $request){
        $user = User::where([
                ['username', '=', strtolower($request->username)],
                ['password', '=', $request->password]
            ])->first();
        if($user != NULL) { // if user exsist
            $garendong = Garendong::where('user_id', '=', $user->id)
                            ->first();
            return Response::json(array(
                'error'=>false,
                'garendong_id'=>$garendong->id),
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
