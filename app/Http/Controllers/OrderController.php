<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
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
            ['order_status', '<>', 5],
            ['order_status', '<>', 6]
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
        if($request->status_id == 2131558546){
            $order->order_status = 4;    
        } else if ($request->status_id == 2131558547){
            $order->order_status = 6;
        } else if ($request->status_id == 2131558547){
            $order->order_status = 6;
        }
        $order->save();

        return 'Pesanan selesai';
        // return redirect(); buat SMS
    }

    public function getStateStatus($id) {
        //get order, garendon name, and status from database
        $order = Order::find($id);
        $garendong = User::select('name')->where('id', $order->garendong_id)->first();
        $status = $order->status;
        // check garendong empty or not
        if (empty($garendong)) {
            $garendong = "Gerry Kastogi";
        } else {
            $garendong = ucwords($garendong->name);
        }

        return Response::json(array(
            'error'=>false,
            'order'=>$order,
            'garendong'=>$garendong),
            200
        );
    }

    public function addRating(Request $request) {
        //add rating to order table
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        $order->rating = $request->rating;
        $order->save();

        //add rating to garendong table
        $garendong_id = $order->garendong_id;
        $garendong = Garendong::find($garendong_id);
        $garendong->rating = $garendong->rating + $request->rating;
        $garendong->num_rating = $garendong->num_rating + 1;
        $garendong->save();
        
        return "Terima kasih atas umpan balik Anda";
    }

    public function getOrderHistory($id) {
        //get order history with success status and rating still null
        $histories = Order::where([
            ['order_status', '=', 4],
            ['customer_id', '=', $id],
            ['rating', '=', null],
        ])->latest()->take(10)->get();        

        return Response::json(array(
            'error'=>false,
            'order'=>$histories->toArray()),
            200
        );
    }

    public function getAllGarendong() {
        //get all garendong from database
        $garendong = Garendong::all();

        return Response::json(array(
            'error'=>false,
            'garendong'=>$garendong->toArray()),
            200
        );
    }

    public function updatePriorityStatus(Request $request){
        $order = Order::find($request->id);
        $user = User::find($order->customer_id);
        $phone = $user->phone_number;
        $order->order_status = 5;
        $order->save();

        return redirect()->action('SMSController@addConverter', ['phone' => $phone, 'text' => "Barang prioritas tidak tersedia" ]);;
    }

    public function getLastOrderID(Request $request) {
        //get last order from one user
        $order_id = Order::select('id')
                    ->where('customer_id', $request->customer_id)
                    ->orderBy('id', 'desc')
                    ->first();

        return $order_id;
    }
}
