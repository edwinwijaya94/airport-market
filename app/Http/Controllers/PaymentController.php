<?php

namespace App\Http\Controllers;

use App\Pay;
use App\Garendong;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Response;
use DateTime;

class PaymentController extends Controller {
	public function addPaymentFactor(Request $request) {
		return view('payment');
    }

    public function addPaymentConstant(Request $request){
    	return 'test';
    }

    public function countPayment(){
    	$jumlah_order = Pay::find(1);
    	$upah_dasar = Pay::find(2);
    	$garendongs = Garendong::all();

    	foreach ($garendongs as $garendong) {
    		if ($garendong->tarif == 0){
    			if ($garendong->number_of_allocation != 0){
    				$garendong->tarif += ($jumlah_order->constant * $garendong->number_of_allocation) + $upah_dasar->constant;
    				$garendong->save();	
    			}
    		} else {
    			if ($garendong->number_of_allocation != 0){
	    			$garendong->tarif -= $garendong->tarif;
	    			$garendong->tarif += ($jumlah_order->constant * $garendong->number_of_allocation) + $upah_dasar->constant;
	    			$garendong->save();
	    		}
    		}
    	}

    	return 'Tarif Berhasil Dihitung';
    }

    public function countRates(){
        $origin = "&origins=";
        $destination = "&destinations=";
        $key = "&key=AIzaSyAT65_OGp-KOIb8aTd9uc3Whh3IbYrVEAY";
        $tarif_dasar = Pay::find(1);
        $tarif_jarak = Pay::find(2);
        $counter = 0;

        $orders = Order::where('rates', '=', 0)
                        ->get();
        $numOrders = count($orders);

        $origin_decode = "Bandung, Jalan Soekarno Hatta, Cipadung Kidul, Bandung City, West Java, Indonesia";
        $origin .= urlencode($origin_decode);

        foreach ($orders as $order) {
            $user = User::find($order->customer_id);

            if($counter==0){
                $destination .= urlencode($user->address);  
            } else{
                $destination = $destination . "|" . urlencode($user->address);
            }

            $client = new Client();
            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial";
            $url = $url . $origin . $destination . $key;
            $response = $client->get($url);

            $body = $response->getBody();

            $data = json_decode($body, true);

            $tarif = $data['rows'][0]['elements'][0]['distance']['value'];
            $tarif *= $tarif_jarak->constant;
            $temp_tarif = $tarif/1000;
            $tarif = intval($temp_tarif) + $tarif_dasar->constant;
            
            $order->rates = $tarif;
            $order->save();

            $destination = "&destinations=";
            $counter++;
        }

        

        return "Perhitungan Tarif Selesai";
    }

    public function countRatesById($id){
        $origin = "&origins=";
        $destination = "&destinations=";
        $key = "&key=AIzaSyAT65_OGp-KOIb8aTd9uc3Whh3IbYrVEAY";
        $tarif_dasar = Pay::find(1);
        $tarif_jarak = Pay::find(2);

        $user = User::find($id);
        $destination .= urlencode($user->address);
        $origin_decode = "Bandung, Jalan Soekarno Hatta, Cipadung Kidul, Bandung City, West Java, Indonesia";
        $origin .= urlencode($origin_decode);

        $client = new Client();
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial";
        $url = $url . $origin . $destination . $key;
        $response = $client->get($url);

        $body = $response->getBody();

        $data = json_decode($body, true);

        $tarif = $data['rows'][0]['elements'][0]['distance']['value'];

        $tarif *= $tarif_jarak->constant;
        $temp_tarif = $tarif/1000;
        $tarif = intval($temp_tarif) + $tarif_dasar->constant;

        return $tarif;
    }

    public function getAllRates(){
        $rates = Pay::all();
        return response()->json($rates);
    }

    public function updateRates(Request $request){
        $tarif_dasar = Pay::find(1);
        $tarif_dasar->constant = $request->tarif_dasar;
        $tarif_dasar->save();

        $tarif_jarak = Pay::find(2);
        $tarif_jarak->constant = $request->tarif_jarak;
        $tarif_jarak->save();
    }
}