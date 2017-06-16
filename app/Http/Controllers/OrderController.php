<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use DateTime;

class OrderController extends Controller {

    protected $connection = 'pgsql_2';

    public function addOrder(Request $request) {
        //add order to database
    	$order = new Order();
        $order->customer_id = $request->customer_id;
        $order->total_product = $request->total_product;        
        $order->order_type = "mobile";
        $order->save();
        //get order id after insert the order to database
        $order_id = $order->id;
        return (string)$order_id;
    }

    public function getAllOrder() {
        //retrieve all orders from datbase
        $orders = Order::all();
        
        return Response::json(array(
            'orders'=>$orders->toArray()),
            200
        );
    }

    public function getOrderById($id) {
        
        $order = Order::where('garendong_id', '=', $id)
                    ->get();

        foreach($order as $item){
            $item = $item->user;
        }

        // return response()->json(array('error' => false, 'order' => $order));
        return response()->json($order);
    }
}
