<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use DateTime;

class OrderController extends Controller {

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

    // public function updateTotalPrice($id, $price)
    // {        
    //     $order = Order::find($id);
    //     $order->total_price = $order->total_price + $price;
    //     $order->save();

    //     return 'Berhasil update total price';
    // }
}
