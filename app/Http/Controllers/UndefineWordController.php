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
}