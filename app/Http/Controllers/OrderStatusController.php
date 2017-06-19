<?php

namespace App\Http\Controllers;

use App\OrderStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;

class OrderStatusController extends Controller
{
	public function getAllStatus() {
	//retrieve all statuses from database
		$statuses = OrderStatus::all();
    	
    	return Response::json(array(
    		'statuses'=>$statuses->toArray()),
    		200
    	);
	}
}
