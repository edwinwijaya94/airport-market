<?php

namespace App\Http\Controllers;

use App\OrderLine;
use App\Order;
use App\Product;
use App\Unit;
use Illuminate\Http\Request;
use Response;

class OrderLineController extends Controller
{
    public function addOrderLine(Request $request, $id) {
        $order_line = json_decode($request->order_line, true);
        foreach ($order_line as $item) {
            $orderLine = new OrderLine();
            $orderLine->order_id = $id;
            $orderLine->product_id = $item['productId'];
            $orderLine->quantity = $item['quantity'];
            $orderLine->unit_id = $item['unitId'];
            $orderLine->is_priority = $item['isPriority'];
            $orderLine->save();
        }
        return "Pesanan Anda berhasil diproses";
    }

    public function getAllOrderLine() {
        //retrieve all categories from datbase
        $orderline = OrderLine::all();
        
        return Response::json(array(
            'orderline'=>$orderline->toArray()),
            200
        );
    }

    public function getOrderLinebyId($id) {

        $order_line = OrderLine::where('order_id', '=', $id)
                        ->get();

        foreach ($order_line as $item) {
            $item = $item->product;
        }

        foreach ($order_line as $apapun) {
            $apapun = $apapun->unit;
        }
        // foreach ($order_line as $item) {
        //     $item = $item->order;
        // }

        return response()->json($order_line);
    }

    public function updateProductPrice(Request $request){
        $orderline = OrderLine::find($request->id);
        $order = Order::find($orderline->order_id);
        if ($orderline->price == 0){
            $order->total_price += $request->price;
            $order->save();
        } else {
            $order->total_price = $order->total_price - $orderline->price + $request->price;
            $order->save();
        }
        $orderline->price = $request->price;
        $orderline->is_available = true;
        $orderline->save();        

        return 'Berhasil Update';
    }

    public function updateStatus(Request $request){
        $orderline = OrderLine::find($request->id);
        $order = Order::find($orderline->order_id);
        if ($orderline->price != 0){
            $order->total_price -= $orderline->price;
            $orderline->price = 0;
            $order->save();
        }
        $orderline->is_available = false;
        $orderline->save();

        return 'Status false';
    }
}
