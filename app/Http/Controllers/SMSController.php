<?php

namespace App\Http\Controllers;

use App\SMS;
use App\Dictionary;
use App\UndefineWord;
use App\User;
use App\Role;
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

    public function getAllSMS() {
        $sms = SMS::all();

        return Response::json(array(
            'sms'=>$sms->toArray()),
            200
        );
    }


    public function sendMessage($text, $phone) {
        //send message to user
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

    public function findUserID($phone) {
        //retrieve user id from database
        $user = User::where('phone_number', $phone)->first();
        if($user == NULL) {
            $user_id = NULL;
        } else {
            $user_id = $user->id;
        }
        
        return $user_id;
    }

    private function getRoleID() {
        //retrieve role pembeli from database
        $role = Role::where('name', 'pembeli')->first();

        return $role->id;
    }

    public function getAbbreviation() {
        //retrieve all abbreviation from dictionaries database
        $collection = Dictionary::all();
        $keyed = $collection->mapWithKeys(function ($item) {
            return [$item['abbreviation'] => $item['word']];
        });
        return $keyed->all();
    }

    public function findProductID($product_name) {        
        //retrieve product id from database
        $product = Product::where('name', $product_name)->first();

        if($product == NULL) {
            $product_id = NULL;
        } else {
            $product_id = $product->id;
        }

        return $product_id;
    }

    public function findUnitID($unit_name) {
        //retrieve unit id from database
        $unit = Unit::where('unit', $unit_name)->first();
        if($unit == NULL) {
            $unit_id = NULL;
        } else {
            $unit_id = $unit->id;
        }
        
        return $unit_id;
    }

    public function getOrderLine($order_line) {
        //parsing orderline and add to array
        $undefine_array = array();
        foreach ($order_line as $item) {
            $re = '/(\d+)(\s?\S+)/ix';
            preg_match($re, $item, $matches);
            //get product name
            $product = str_replace($matches[0], '', $item);
            $product = trim($product);
            $product_id = self::findProductID($product);
            //get unit name
            $unit = trim($matches[2], " ");
            $unit_id = self::findUnitID($unit);
            if ($product_id == NULL) {
                var_dump('product');
                array_push($undefine_array, $product);
            } else if ($unit_id == NULL) {
                var_dump('unit');
                array_push($undefine_aray, $unit);
            } else if ($product_id == NULL && $unit_id == NULL) {
                var_dump('product & unit');
                array_push($undefine_array, $product);
                array_push($undefine_array, $unit);
            }else {
                $orderlines[] = array(
                    "productId" => $product_id,
                    "quantity" => trim($matches[1], " "),
                    "unitId" => $unit_id,
                    "isPriority" => false
                );
            }
        }

        if (count($undefine_array) != 0) {
            //add undefine word to database
            foreach ($undefine_array as $word) {
                $undefine_word = UndefineWord::where('undefine_word', $word)->first();
                if ($undefine_word == NULL) { //check is undefine word already exist
                    $undefine = new UndefineWord();
                    $undefine->undefine_word = $word;
                    $undefine->save();
                }
            }
            return NULL;
        } else { // return all define order line
            return array(
              'order_line'=>$orderlines
            );
        }
    }
    
    public function receiveMessage(Request $request) {
        $inbound_id = $request->id;
        $sender_phone = $request->sender;
        $receiver_phone = $request->receiver;
        $message_time = $request->messageTime;
        $message = $request->text;
        Log::info("Receive Message");
        Log::info($sender_phone);
        Log::info($receiver_phone);
        Log::info($message_time);
        Log::info($message);
        $message = strtolower($message);
        $message = trim($message);
        // add receive message to database
        $sms = new SMS();
        $sms->inbound_id = $inbound_id ;
        $sms->sender = $sender_phone;
        $sms->receiver = $receiver_phone;
        $sms->message_time = $message_time;
        $sms->text = $message;
        $sms->save();

        //parsing section
        if (strpos($message, 'register') !== false) { 
            Log::info('register');
            //get user id from message
            $user_id = self::findUserID($sender_phone);
            if ($user_id == NULL) { // register section
                //parse message
                $keyword = "register";
                $pos = strpos($message, $keyword) + strlen($keyword);
                $customer = substr($message, $pos);
                $customer = trim($customer);
                $customer = explode("\n", $customer);
                $name = trim($customer[0]);
                $address = trim($customer[1]); 
                $role_id = self::getRoleID();
                $password = str_replace(' ', '', $name);
                //add user to database
                $user = new User();
                $user->role_id = $role_id ;
                $user->name = $name ;
                $user->username = $sender_phone;
                $user->address = $address;
                $user->phone_number = $sender_phone;
                $user->password = bcrypt($password);
                $user->save();

                //send status to user
                Log::info('success register');
                $text = "[PAYAKUMBUH] Nomor Anda berhasil terdaftar.";
                self::sendMessage($text, $sender_phone);

                return Response::json(array(
                    'error'=>false,
                    'message'=>"Nomor Anda berhasil terdaftar"),
                    200
                );
            } else {
                //send message to user that user already register
                $text = "Nomor ini sudah terdaftar";
                self::sendMessage($text, $sender_phone);
            }
        } else if (stripos($message, 'ubah alamat') !== false) { 
            Log::info('alamat');
            //get user id
            $user_id = self::findUserID($sender_phone);
    
            if ($user_id == NULL) {
                //send message to user that user have not register
                $text = "[PAYAKUMBUH] Nomor ini belum terdaftar. Silahkan register terlebih dahulu dengan format berikut:\nRegister\nBudi\nJl Dago No.12";
                self::sendMessage($text, $sender_phone);
            } else {
                //parse message
                $keyword = "ubah alamat";
                $pos = stripos($message, $keyword) + strlen($keyword);
                $address = substr($message, $pos);
                $address = trim($address); 

                //update address in database
                $user = User::find($user_id);
                $user->address = $address;
                $user->save();

                //send order status to user
                Log::info('success change');
                $text = "[PAYAKUMBUH] Alamat Anda berhasil diubah";
                self::sendMessage($text, $sender_phone);

                return Response::json(array(
                    'error'=>false,
                    'message'=>"Alamat Anda berhasil diubah"),
                    200
                );
            }
        } else if (strpos($message, 'pesan') !== false) {
            Log::info('pesan');
            //get user id
            $user_id = self::findUserID($sender_phone);
    
            if ($user_id == NULL) {
                //send message to user that user have not register
                $text = "[PAYAKUMBUH] Nomor ini belum terdaftar. Silahkan register terlebih dahulu dengan format berikut:\nRegister\nBudi\nJl Dago No.12";
                self::sendMessage($text, $sender_phone);
            } else {
                //replace abbreviation based on database
                $replacements = self::getAbbreviation();
                $message = strtr($message, $replacements);
                var_dump($message);
                //parse message
                $keyword = "pesan";
                $pos = strpos($message, $keyword) + strlen($keyword);
                $order = substr($message, $pos);
                $order = trim($order);
                $order_line = explode("\n", $order);
                $orderLine = self::getOrderLine($order_line);
                if ($orderLine == NULL) {
                    //send message to user that abbreviaion not define in system
                    Log::info('undefine word');
                    $text = "[PAYAKUMBUH] Singkatan Anda tidak dimengerti oleh sistem. Silahkan kirim ulang pesanan Anda tanpa menggunakan singkatan.";
                    self::sendMessage($text, $sender_phone);
                } else {
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

                    //send order status to user
                    Log::info('success order');
                    $text = "[PAYAKUMBUH] Pesanan Anda berhasil diproses";
                    self::sendMessage($text, $sender_phone);

                    return Response::json(array(
                        'error'=>false,
                        'message'=>"Pesanan Anda berhasil diproses"),
                        200
                    );
                }
            }
        } else {
            Log::info('wrong format');
            //send message to user that wrong format
            $text = "[PAYAKUMBUH] Format SMS Anda salah. Silahkan kirim ulang SMS Anda dengan format yang benar.";
            self::sendMessage($text, $sender_phone);

        }
    }
}