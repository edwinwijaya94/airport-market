<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Shopper;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
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
        $user->phone_number = $request->phone;
        $user->password = $request->password;
        $user->save();

        // $address_obj = new Address();
        // $client = new Client();
        // $key = "&key=AIzaSyAT65_OGp-KOIb8aTd9uc3Whh3IbYrVEAY";
        // $address = "address=";
        // $url = "https://maps.googleapis.com/maps/api/geocode/json?";    

        // $address .= urlencode($request->address);
        // $url .= $address . $key;
        // $response = $client->get($url);

        // $body = $response->getBody();

        // $data = json_decode($body, true);

        $user = User::where('username', '=', strtolower($request->username))
                    ->first();
                    
        // $address_obj->user_id = $user->id;
        // $address_obj->latitude = $data['results'][0]['geometry']['location']['lat'];
        // $address_obj->longitude = $data['results'][0]['geometry']['location']['lng'];
        // $address_obj->save;

        return "Selamat Anda sudah terdaftar di Airport Market";
    }

    public function updateUser(Request $request) {
        //update order to database
        User::where('id', $request->id)
            ->update(array(
                        'name' => strtolower($request->name),
                        'phone_number' => $request->phone)
                    );

        return "Profile Anda berhasil diubah";
    }

    public function addShopper(Request $request) {
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
        $shopper = new Shopper();
        $shopper->user_id = $user->id;
        $shopper->save();

        return "Selamat Anda sudah terdaftar di Airport Market";
    }

    public function shopperLogin(Request $request){
        $user = User::where([
                ['username', '=', strtolower($request->username)],
                ['password', '=', $request->password]
            ])->first();
        if($user != NULL) { // if user exsist
            $shopper = Shopper::where('user_id', '=', $user->id)
                            ->first();
            return Response::json(array(
                'error'=>false,
                'shopper_id'=>$shopper->id),
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
