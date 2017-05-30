<?php

namespace App;

use App\ReasonList;
use Illuminate\Database\Eloquent\Model;
use Response;

class ReasonList extends Model
{
    public function addReasonList(Request $request, $id) {
        $reasonLists = json_decode($request->reason_list, true);
        foreach ($reasonLists as $reasonList) {
            $reasonList = new ReasonList();
            $reasonList->order_id = $id;
            $reasonList->rating = $item['rating'];
            $reasonList->reason_id = $item['reason_id'];
            $reasonList->save();
        }
        return "Terima kasih sudah Memberikan Umpan Balik";
    }
}
