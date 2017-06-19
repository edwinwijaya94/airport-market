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
        $order = Order::where([
            ['garendong_id', '=', $id],
            ['order_status', '<>', 4],
            ])->get();
        
        foreach($order as $item){
            $item = $item->user;
        }

        return response()->json($order);
    }

    public function updateDeliveryStatus(Request $request){
        $order = Order::find($request->id);
        $order->order_status = 3;
        $order->save();

        return 'Pesanan sedang dikirim';
    }

    public function updateConfirmationStatus(Request $request){
        $order = Order::find($request->id);
        $order->order_status = 4;
        $order->save();

        return 'Pesanan selesai';
    }
}
