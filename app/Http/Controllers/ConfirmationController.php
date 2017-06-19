<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use DateTime;

class ConfirmationController extends Controller {
	public function getDetailOrder($id) {

        $order = Order::where('id', '=', $id)
                    ->get();

        foreach($order as $item){
            $item = $item->user;
        }

        // return response()->json(array('error' => false, 'order' => $order));
        return response()->json($order);
    }
}