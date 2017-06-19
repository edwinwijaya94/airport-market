<?php

namespace App\Http\Controllers;

use App\UserFeedback;
use Illuminate\Http\Request;
use Response;

class UserFeedbackController extends Controller
{
    
    public function addFeedback(Request $request) {
        $feedbacks = json_decode($request->feedback, true);
        foreach ($feedbacks as $reason) {
            $feedback = new UserFeedback();
            $feedback->order_id = $request->order_id;
            $feedback->reason_id = $reason;
            $feedback->save();
        }
        return "Terima kasih atas umpan balik Anda";
    }

    public function getAllFeedback() {
        $feedbacks = UserFeedback::all();

        return Response::json(array(
            'feedbacks'=>$feedbacks->toArray()),
            200
        );
    }
}
