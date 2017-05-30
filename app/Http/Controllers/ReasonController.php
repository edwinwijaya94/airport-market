<?php

namespace App\Http\Controllers;

use App\Reason;
use Illuminate\Http\Request;
use Response;

class ReasonController extends Controller
{
    public function getAllReasons() {
        //retrieve all reasons from database
        $reasons = Reason::all();
        
        return Response::json(array(
            'reasons'=>$reasons->toArray()),
            200
        );
    }
}
