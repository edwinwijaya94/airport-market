<?php

namespace App\Http\Controllers;

use App\UndefineWord;
use Illuminate\Http\Request;
use Textmagic\Services\TextmagicRestClient;
use Response;

class UndefineWordController extends Controller
{
    public function getAllUndefineWord() {
        $undefine = UndefineWord::all();

        return Response::json(array(
            'undefine'=>$undefine->toArray()),
            200
        );
    }

    public function deleteUndefineWord($id) {
    	//delete data of undefine word from database
        $undefine = UndefineWord::find($id);
        $undefine->delete();

        return Response::json(array(
            'error'=>false,
            'message'=>"Singkatan berhasil ditambahkan"),
            200
        );
    }
}