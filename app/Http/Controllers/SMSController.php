<?php

namespace App\Http\Controllers;

use App\SMS;
use App\User;
use App\Product;
use App\Unit;
use App\Order;
use App\OrderLine;
use Log;
use Illuminate\Http\Request;
use Textmagic\Services\TextmagicRestClient;
use Response;

class SMSController extends Controller
{
    public function sendMessage($text, $phone) {
        $client = new TextmagicRestClient('jessicaandjani', 'Z1HuSc1UIKQMgOfmGeFmtmAMMRH7GK');
        $result = ' ';
        try {
            $result = $client->messages->create(
                array(
                    'text' => $text,
                    'phones' => implode(', ', array($phone))
                )
            );
        } catch (\Exception $e) {
            if ($e instanceof RestException) {
                print '[ERROR] ' . $e->getMessage() . "\n";
                foreach ($e->getErrors() as $key => $value) {
                    print '[' . $key . '] ' . implode(',', $value) . "\n";
                }
            } else {
                print '[ERROR] ' . $e->getMessage() . "\n";
            }
            return;
        }
    }

    public function getAbbreviation() {
        //get all abbreviation from dictionaries database
        $collection = SMS::all();
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item['abbreviation'] => $item['word']];
        });
        return $keyed->all();
    }

    public function parseMessage($message) {
        // parse incoming message
        $sentence = explode("pesan", $message);
        $sentence_arr = array(
            "user_section" => trim($sentence[0]),
            "order_section" => trim($sentence[1]),
            );
        
        return $sentence_arr;
    }

    public function findUserID($phone) {
        $user = User::where('phone_number', $phone)->first();
        if($user == NULL) {
            $user_id = NULL;
        } else {
            $user_id = $user->id;
        }
        
        return $user_id;
    }

    public function findProductID($product_name) {        
        $product = Product::where('name', $product_name)->first();
        if($product == NULL) {
            $product_id = NULL;
        } else {
            $product_id = $product->id;
        }

        return $product_id;
    }

    public function findUnitID($unit_name) {
        $unit = Unit::where('unit', $unit_name)->first();
        if($unit == NULL) {
            $unit_id = NULL;
        } else {
            $unit_id = $unit->id;
        }
        
        return $unit_id;
    }

    public function getOrderLine($order_line) {
        $orderline_array = array();
        foreach ($order_line as $item) {
            //get quantity and unit
            $re = '/(\d+)(\s?\S+)/ix';
            preg_match($re, $item, $matches);
            $product = str_replace($matches[0], '', $item);
            $product = trim($product);
            $product_id = self::findProductID($product);
            $unit = trim($matches[2], " ");
            $unit_id = self::findUnitID($unit);
            $orderlines[] = array(
                    "productId" => $product_id,
                    "quantity" => trim($matches[1], " "),
                    "unitId" => $unit_id,
                    "isPriority" => false
                );
        }

        return array(
            'order_line'=>$orderlines
        );
    }

    public function receiveMessage(Request $request) {
        $sender_phone = $request->sender;
        $message = $request->text;
        Log::info('hi: ' . "halloo");
        // change all abbreviation
        $message = strtolower($message);
        $replacements = self::getAbbreviation();
        $message = strtr($message, $replacements);
        Log::info('message: ' . $message);
        Log::info('phone: ' . $sender_phone);
        //get user id from message
        $user_id = self::findUserID($sender_phone);
        if ($user_id == NULL) { // user id null
            $user_profile = self::parseMessage($message)["user_section"];
            Log::info('user: ' . $user_profile);
            if($user_profile != "") { // add new user to database
                $customer = explode(",", $user_profile);
                $name = trim($customer[0]);
                $username = str_replace(' ', '', $name);
                $address = trim($customer[1]);
                //add to database
                $user = new User();
                $user->name = $name ;
                $user->username = $username;
                $user->address = $address;
                $user->phone_number = $sender_phone;
                $user->save();
                $user_id = $user->id; // get id after insert to database
                //parse message to get order line
                $order_line = self::parseMessage($message)["order_section"];
                Log::info('order: ' . $order_line);
                $order_line = explode("\n", $order_line);
                $total_product = count($order_line);
                $order_line = self::getOrderLine($order_line)['order_line'];
                //add order to database
                $order = new Order();
                $order->customer_id = $user_id;
                $order->total_product = $total_product;
                $order->order_type = "SMS";
                $order->save();
                $order_id = $order->id; // get order id
                //add order line to database
                foreach ($order_line as $item) {
                    $orderLine = new OrderLine();                
                    $orderLine->order_id = $order_id;
                    $orderLine->product_id = $item['productId'];
                    $orderLine->quantity = $item['quantity'];
                    $orderLine->unit_id = $item['unitId'];
                    $orderLine->is_priority = $item['isPriority'];
                    $orderLine->save();
                }
                //send order status
                Log::info('success');
                $text = "Pesanan Anda berhasil diproses";
                self::sendMessage($text, $sender_phone);

                return Response::json(array(
                    'error'=>false,
                    'message'=>"Pesanan Anda berhasil diproses"),
                    200
                );
            } else {
                Log::info('send message');
                // send message to user
                $text = "Anda belum teregistrasi. Silahkan kirim ulang SMS Anda dengan contoh format berikut:\n Mawar, Jl Pajajaran No.12\n Pesan\n 1 kg ayam\n 2 ikat kangkung ";
                self::sendMessage($text, $sender_phone);
                
            }
        } else {
            //parse message to get order line
            $order_line = self::parseMessage($message)["order_section"];
            Log::info('order2: ' . $order_line);
            $order_line = explode("\n", $order_line);
            $total_product = count($order_line);
            $order_line = self::getOrderLine($order_line)['order_line'];
            //add order to database
            $order = new Order();
            $order->customer_id = $user_id;
            $order->total_product = $total_product;
            $order->order_type = "SMS";
            $order->save();
            $order_id = $order->id; // get order id
            //add order line to database
            foreach ($order_line as $item) {
                $orderLine = new OrderLine();                
                $orderLine->order_id = $order_id;
                $orderLine->product_id = $item['productId'];
                $orderLine->quantity = $item['quantity'];
                $orderLine->unit_id = $item['unitId'];
                $orderLine->is_priority = $item['isPriority'];
                $orderLine->save();
            }
            //send order status
            Log::info('success');
            $text = "Pesanan Anda berhasil diproses";
            self::sendMessage($text, $sender_phone);

            return Response::json(array(
                'error'=>false,
                'message'=>"Pesanan Anda berhasil diproses"),
                200
            );
        }
    }
}