<?php

namespace App\Http\Controllers;

use App\Order;
use App\Garendong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

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

        $numberAllocation = Order::where('garendong_id', '=', $id)
                                ->count();
        $garendong = Garendong::find($id);
        if ($garendong->number_of_allocation == 0){
            $garendong->number_of_allocation += $numberAllocation;
            $garendong->save();
        } else {
            $garendong->number_of_allocation -= $garendong->number_of_allocation;
            $garendong->number_of_allocation += $numberAllocation;
            $garendong->save();
        }
        
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
        // return redirect(); buat SMS
    }

    public function updateConfirmationStatus(Request $request){
        $order = Order::find($request->id);
        $order->order_status = 4;
        $order->save();

        return 'Pesanan selesai';
        // return redirect(); buat SMS
    }

    public function getStateStatus($id) {
        $order = Order::find($id);

        return Response::json(array(
            'error'=>false,
            'state_status'=>$order),
            200
        );
    }

    public function addRating(Request $request) {
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        $order->rating = $request->rating;
        $order->save();
        
        return "Terima kasih atas umpan balik Anda";
    }

    public function getOrderHistory() {
        $histories = Order::where('order_status', '=', 1)->get();

        return Response::json(array(
            'error'=>false,
            'order'=>$histories->toArray()),
            200
        );
    }
}
