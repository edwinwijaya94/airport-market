<?php

namespace App\Http\Controllers;

use App\Order;
use App\Shopper;
use App\User;
use Phpml\Clustering\KMeans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Response;
use DateTime;

class AllocationController extends Controller {
	public function allocateGarendong() {
		$orders = Order::all();

		foreach ($orders as $order) {
            $minAllocation = Shopper::min('number_of_allocation');
            $garendong = Shopper::where('number_of_allocation', '=', $minAllocation)
                                    ->limit(1)
                                    ->get();
			if($order->shopper_id == 0){
				$order->shopper_id = $garendong[0]->id;
                $allocatedGarendong = Shopper::find($garendong[0]->id);
                $allocatedGarendong->number_of_allocation++;
                $allocatedGarendong->save();
                $order->order_status = 2;   
                $order->save();
            }
		}

		return 'Garendong berhasil dialokasikan';
    }

    public function findMin(int $a, int $b){
        if ($a<=$b)
            return $a;
        else
            return $b;
    }

    public function allocateGarendongByDistance() {
    	$counter=0;
        $arOrderId=array();
    	$origin = "&origins=";
    	$destination = "&destinations=";
    	$key = "&key=AIzaSyAT65_OGp-KOIb8aTd9uc3Whh3IbYrVEAY";
    	
    	$orders = Order::where('garendong_id', '=', 0)
    					->limit(4)
                        ->get();
        $numOrders = count($orders);

    	foreach ($orders as $order) {
    		$user = User::find($order->customer_id);
    		if($counter==0){
    			$origin .= urlencode($user->address);
    			$destination .= urlencode($user->address);	
    		} else{
    			$origin = $origin . "|" . urlencode($user->address);
    			$destination = $destination . "|" . urlencode($user->address);
    		}
            $arOrderId[$counter] = $order->id;
    		$counter++;
            $order->garendong_id = 1;
    	}

    	$client = new Client();
    	$url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial";
    	$url = $url . $origin . $destination . $key;
    	$response = $client->get($url);

    	$body = $response->getBody();

    	$data = json_decode($body, true);
    
    	$distanceMatrix = array(
    			array(0, 0, 0, 0),
    			array(0, 0, 0, 0),
    			array(0, 0, 0, 0),
    			array(0, 0, 0, 0)
    		);
    	
    	for ($i=0; $i < $numOrders; $i++) {
    		for ($j=0; $j < $numOrders; $j++) {
    			if($i==$j){
    				$distanceMatrix[$i][$j] = $data['rows'][$i]['elements'][$j]['distance']['value'];
    			} else{
    				$distanceMatrix[$i][$j] = $data['rows'][$i]['elements'][$j]['distance']['value'];
    				$distanceMatrix[$j][$i] = $data['rows'][$i]['elements'][$j]['distance']['value'];
    			}
    		}
    	}
    	
        for ($i=0; $i<$numOrders; $i++) {
            for ($j=$i+1; $j<$numOrders-1; $j++){
                $minimum = findMin($distanceMatrix[$i][$j], $distanceMatrix[$i][$j+1]);
                if($minimum<=$maxDistance){
                    $arSameOrder[0] = $arOrderId[i];
                    $arSameOrder[1] = $arOrderId[j];
                }    
            }
        }

    	// for ($row=0; $row < $numOrders ; $row++) { 
    	// 	for ($column=0; $column < $numOrders ; $column++) { 
    	// 		echo $distanceMatrix[$row][$column], "&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp";
    	// 	}
    	// 	echo "<br>";
    	// }
    	// echo "<br>";

    	return 'Alokasi berdasarkan jarak berhasil';
    }

    public function allocateGarendongKMeans() {
        $matrixLocation = array();
        $arrayLocation = array();
        $key = "&key=AIzaSyAT65_OGp-KOIb8aTd9uc3Whh3IbYrVEAY";
        $address = "address=";
        $client = new Client();
        $url = "https://maps.googleapis.com/maps/api/geocode/json?";

        $orders = Order::where('garendong_id', '=', 0)
                        ->get();
        $numOrders = count($orders);

        foreach ($orders as $order) {
            $user = User::find($order->customer_id);
            $address = Address::where('user_id', '=', $user->id)->first();

            array_push($arrayLocation, $address->latitude, $address->latitude);
        }
        
        $counter = 0;
        while ($counter < $numOrders*2) {
            array_push($matrixLocation, array($arrayLocation[$counter], $arrayLocation[$counter+1]));
            $counter += 2;
        }

        // for ($row=0; $row<$numOrders; $row++) { 
        //     for ($column=0; $column<2; $column++) { 
        //         echo $matrixLocation[$row][$column], "&nbsp &nbsp &nbsp &nbsp &nbsp";
        //     }
        //     echo "<br>";
        // }
        // echo "<br>";

        $kmeans = new KMeans(2);
        var_dump($kmeans->cluster($matrixLocation));

        $orders = Order::all();

        foreach ($orders as $order) {
            $minAllocation = Garendong::min('number_of_allocation');
            $garendong = Garendong::where('number_of_allocation', '=', $minAllocation)
                                    ->limit(1)
                                    ->get();
            if($order->garendong_id == 0){
                $order->garendong_id = $garendong[0]->id;
                $allocatedGarendong = Garendong::find($garendong[0]->id);
                $allocatedGarendong->number_of_allocation++;
                $allocatedGarendong->save();
                $order->order_status = 2;   
                $order->save();
            }
        }

        return 'KMeans Allocation Sukses';
    }
}