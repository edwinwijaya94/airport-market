<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
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

    function getOrder(Request $request, $id) {
        //retrieve order by id from database
        $status = Order::find($id);


        return Response::json(array(
            'error'=>false,
            'status'=>$status),
            200
        );
    }

    function getOrder(Request $request, $id) {
        //retrieve order by id from database
        // $status = Order::find($id);


        // return Response::json(array(
        //     'customer_id'=>1,
        //     'status'=>$status),
        //     200
        // );
        $order = DB::table('orders')
                    ->join('users', 'orders.customer_id', '=', 'users.id')
                    -> select(DB::raw('users.name, total_products, total_price, 
                        garendong_id,order_status'))
                    -> where('customer_id', '=', $id)
                    -> get();

        // return response()->json(array('error' => false, 'order' => $order));
        return response()->json($order);
    }
}
