<?php

namespace App\Http\Controllers;

use App\Pay;
use App\Garendong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
}