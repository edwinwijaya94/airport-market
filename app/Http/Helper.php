<?php

namespace App\Http;

use Carbon\Carbon;

class Helper {
	private static $email = 'edwinwijaya1994%40gmail.com';
	private static $accessCode = '8b66157a';
    public static  $minDuration = 30; // minimum duration to departure time for making order

	public static function getFormEncoded(string $branch, string $api, string $dataType) {

		return 'email='.self::$email.'&accesscode='.self::$accessCode.'&api='.$api.'&branch='.$branch.'&data_type='.$dataType.'&submit=';
	}

    // format passenger name from boarding pass
    public static function formatName(string $name) {
        $nameArr = explode('/', trim(strtolower($name), ' '));
        $res = '';
        for($i=count($nameArr)-1; $i>=0; $i--) {
            $res .= $nameArr[$i];
            if($i>0)
                $res .= ' ';
        }
        
        return $res;
    }

    public static function formatFlightNumber(string $airline, string $flightNumber) {
        $airlineFormatted = trim($airline, ' ');
        $flightNumberFormatted = trim($flightNumber, ' ');
        // if($flightNumberFormatted[0] == '0')
        //     $flightNumberFormatted = substr($flightNumberFormatted, 1);

        $result = $airlineFormatted.' '.$flightNumberFormatted;
        return $result;
    }

    // get departure time only (format H:i:s)
    public static function getDepartureTime($flightData, string $flightNumber) {
        $departureTime = '';
        for($i=0; $i<count($flightData); $i++) {
            if($flightData[$i]['FLIGHT_NO'] == $flightNumber)
                $departureTime = Carbon::createFromFormat('Y-m-d H:i:s', $flightData[$i]['SCHEDULED'])->toTimeString();
        }

        return $departureTime;
    }    

    public static function removeHTMLTag($data) {
        $res = $data;
        for($i=0; $i<count($res); $i++) {
            // dd($res[$i]);
            $res[$i]['OBJECT_ADDRESS'] = preg_replace('#<[^>]+>#', ' ', $res[$i]['OBJECT_ADDRESS']);
            $res[$i]['OBJECT_DESC'] = preg_replace('#<[^>]+>#', ' ', $res[$i]['OBJECT_DESC']);
            $res[$i]['OBJECT_DESC_ENG'] = preg_replace('#<[^>]+>#', ' ', $res[$i]['OBJECT_DESC_ENG']);

            $res[$i]['OBJECT_ADDRESS'] = str_replace(['&nbsp;', '&amp;', '&ndash;'], ' ', $res[$i]['OBJECT_ADDRESS']);
            $res[$i]['OBJECT_DESC'] = str_replace(['&nbsp;', '&amp;', '&ndash;'], ' ', $res[$i]['OBJECT_DESC']);
            $res[$i]['OBJECT_DESC_ENG'] = str_replace(['&nbsp;', '&amp;', '&ndash;'], ' ', $res[$i]['OBJECT_DESC_ENG']);
            // $res[$i]['OBJECT_ADDRESS'] = strip_tags($res[$i]['OBJECT_ADDRESS']);
            // $res[$i]['OBJECT_DESC'] = strip_tags($res[$i]['OBJECT_DESC']);
            // $res[$i]['OBJECT_DESC_ENG'] = strip_tags($res[$i]['OBJECT_DESC_ENG']);
        }

        return $res;
    }

    // helper function to make HTTP request
    public static function curl(string $method, string $url, string $formEncoded) {
        // return $url;
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $formEncoded,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_HTTPHEADER => array(
          "cache-control: no-cache",
          "content-type: application/x-www-form-urlencoded"
          // "postman-token: b6c7831c-52a0-d8f6-d6d5-ae7fc3c2b82f"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return "cURL Error #:" . $err;
        } else {
          return $response;
        }
    }

}