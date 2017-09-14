<?php

namespace App\Http\Controllers;

use App\Order;
use App\User;
use App\Garendong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Http\Helper;
use Carbon\Carbon;

class OrderController extends Controller {

    // authorize new order using boarding pass data
    public function authorizeOrder(Request $request) {
        $name = strtolower($request->name);
        $boardingPassData = $request->boarding_pass_data;
        $url = 'https://www.flighthistorian.com/boarding-pass/json/'.rawurlencode($boardingPassData);
        $res = json_decode(Helper::curl('GET', $url, ''), true);
        
        // get required boarding pass info
        $bpData = array();
        $bpData['passengerName'] = $res['unique']['mandatory']['11']['raw'];
        $bpData['flightNumber'] = Helper::formatFlightNumber($res['repeated'][0]['mandatory']['42']['raw'], $res['repeated'][0]['mandatory']['43']['raw']);
        $bpData['departureAirport'] = $res['repeated'][0]['mandatory']['26']['raw'];
        $bpData['flightDate'] = Carbon::parse('first day of January '.date('Y'))->addDays((int)$res['repeated'][0]['mandatory']['46']['raw'] - 1)->toDateString();
        // dd($bpData['flightDate']);
        $isValid = array();
        //check if name is matched with boarding pass
        if(Helper::formatName($bpData['passengerName']) == $name ) {
            $isValid['name'] = array(); 
            $isValid['name']['status'] = true;
            $isValid['name']['message'] = 'Nama sesuai boarding pass';
        } else {
            $isValid['name'] = array(); 
            $isValid['name']['status'] = false;
            $isValid['name']['message'] = 'Nama tidak sesuai boarding pass';
        }
        
        //check if departure time fulfill min. duration
        $formEncoded = Helper::getFormEncoded($bpData['departureAirport'], 'FLG', '');
        $flightData = json_decode(Helper::curl('POST', 'https://developer.angkasapura2.co.id/va/Api/getApidata', $formEncoded), true);
        $departureTime = Helper::getDepartureTime($flightData, $bpData['flightNumber']);
        
        $departureTime = Carbon::createFromFormat('Y-m-d H:i:s', $bpData['flightDate'].' '.$departureTime);
        $currentTime = Carbon::now('Asia/Jakarta'); // require airport tz, currently set to WIB !
        var_dump($departureTime->toDateTimeString());
        var_dump($currentTime->toDateTimeString());
        $duration = $currentTime->diffInMinutes($departureTime, false);
        var_dump($duration);
        if($duration > Helper::$minDuration) {
            $isValid['departureTime'] = array(); 
            $isValid['departureTime']['status'] = true;
            $isValid['departureTime']['message'] = 'Durasi waktu tunggu memungkinkan';
        } else {
            $isValid['departureTime'] = array(); 
            $isValid['departureTime']['status'] = false;
            $isValid['departureTime']['message'] = 'Durasi waktu tunggu tidak memungkinkan';
        }

        return response()->json([
                'data' => $isValid
            ]);
    }

    public function addOrder(Request $request) {
        //add order to database
    	$order = new Order();
        $order->customer_id = $request->customer_id;
        $order->total_product = $request->total_product;
        $order->customer_location = $request->customer_location;
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
            ['shopper_id', '=', $id],
            ['order_status', '<>', 4],
            ['order_status', '<>', 5],
            ['order_status', '<>', 6]
            ])->get();

        $numberAllocation = Order::where('shopper_id', '=', $id)
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
        $user = User::find($order->customer_id);
        $phone = $user->phone_number;
        $order->order_status = 3;
        $order->save();
        if ($order->order_type != "mobile"){
            return redirect()->action('SMSController@sendMessage', ['text' => "[PAYAKUMBUH]\nStatus pesanan Anda:\nSedang dalam pengiriman", 'phone' => $phone ]);
        } else {
            return 'Pesanan sedang dikirim';    
        }
        // return redirect(); buat SMS
    }

    public function updateConfirmationStatus(Request $request){
        $order = Order::find($request->id);
        $user = User::find($order->customer_id);
        $phone = $user->phone_number;
        if($request->status_id == 2131558546){
            $order->order_status = 4;
            $order->save();
            return 'Pesanan selesai';
        } else if ($request->status_id == 2131558547){
            $order->order_status = 6;
            $order->save();
            return redirect()->action('SMSController@sendMessage', ['text' => "[PAYAKUMBUH]\nStatus pesanan Anda:\nPengiriman gagal", 'phone' => $phone ]);
        } else if ($request->status_id == 2131558547){
            $order->order_status = 6;
            $order->save();
            return redirect()->action('SMSController@sendMessage', ['text' => "[PAYAKUMBUH]\nStatus pesanan Anda:\nPengiriman gagal", 'phone' => $phone ]);
        }
        
        // return redirect(); buat SMS
    }

    public function getStateStatus($id) {
        //get order, garendon name, and status from database
        $order = Order::find($id);
        $garendong = User::select('name')->where('id', $order->shopper_id)->first();
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

    public function getLastOrderID(Request $request) {
        //get last order from one user
        $order_id = Order::select('id')
                    ->where('customer_id', $request->customer_id)
                    ->orderBy('id', 'desc')
                    ->first();

        return $order_id;
    }
}
