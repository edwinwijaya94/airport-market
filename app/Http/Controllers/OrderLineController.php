<?php

namespace App\Http\Controllers;

use App\OrderLine;
use App\Order;
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
            $item = $item->order;
        }


        return response()->json($order_line);
    }

    public function updateProductPrice(Request $request){
        $orderline = OrderLine::find($request->id);
        var_dump($request->id);
        var_dump($request->price);
        $orderline->price = $request->price;
        $orderline->save();

        $order = Order::find($orderline->order_id);
        $order->total_price = $order->total_price + $request->price;
        $order->save();

        return 'Berhasil Update';
    }
}
