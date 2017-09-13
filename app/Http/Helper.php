<?php

namespace App\Http;

class Helper
{
	private static $email = 'edwinwijaya1994%40gmail.com';
	private static $accessCode = '8b66157a';
	private static $api = 'FAC';


	public static function getFormEncoded(string $branch, string $dataType) {

		return 'email='.self::$email.'&accesscode='.self::$accessCode.'&api='.self::$api.'&branch='.$branch.'&data_type='.$dataType.'&submit=';
	}

    // helper function to make HTTP request
    public static function curl(string $method, string $url, string $formEncoded) {
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