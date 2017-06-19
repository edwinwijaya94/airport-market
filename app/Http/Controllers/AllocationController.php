<?php

namespace App\Http\Controllers;

use App\Order;
use App\Garendong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use DateTime;

class AllocationController extends Controller {
	public function allocateGarendong() {
		$orders = Order::all();
		$garendong = 1;

		foreach ($orders as $order) {
			if($order->garendong_id == 0){
				$order->garendong_id = $garendong;
				if($garendong != 4)
					$garendong++;
				else
					$garendong = 1;
			
				$order->order_status = 2;	
				$order->save();
			}
		}

		return 'Garendong berhasil dialokasikan';
    }
}