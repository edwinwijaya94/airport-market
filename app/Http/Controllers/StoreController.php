<?php

namespace App\Http\Controllers;

use App\Store;
use App\Category;
use App\Unit;
use App\Converter;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;
use File;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Http\Helper;

class StoreController extends Controller {

    public function getStores(Request $request) {
        
        $formEncoded = Helper::getFormEncoded($request->branch, $request->data_type);
        $result = Helper::curl('POST', 'https://developer.angkasapura2.co.id/va/Api/getApidata', $formEncoded);

        return response($result)
            ->header('Content-Type', 'application/json');
        
    }

}

