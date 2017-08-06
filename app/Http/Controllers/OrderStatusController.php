<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;

class OrderStatusController extends Controller
{
	public function getAllSuccessStatus() {
	//retrieve all statuses from database
		$statuses = OrderStatus::where('status', '=', true)->get();
    	
    	return Response::json(array(
    		'statuses'=>$statuses->toArray()),
    		200
    	);
	}
}
