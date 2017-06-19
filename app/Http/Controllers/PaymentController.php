<?php

namespace App\Http\Controllers;

use App\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use DateTime;

class PaymentController extends Controller {
	public function addPaymentFactor(Request $request) {
		return view('payment');
    }

    public function addPaymentConstant(Request $request){
    	
    }
}