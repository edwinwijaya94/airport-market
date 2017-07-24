<?php

namespace App\Http\Controllers;

use App\Dictionary;
use Illuminate\Http\Request;
use Textmagic\Services\TextmagicRestClient;
use Response;

class SMSController extends Controller
{

    public function getAllDictionary() {
        //retrieve all abbreviation from dictionary
        $dictionary = Dictionary::all();

        return Response::json(array(
            'dictionary'=>$dictionary->toArray()),
            200
        );
    }

    public function addDictionary(Request $request) {
        //add abbreviation to database
        $dictionary = new Dictionary();
        $dictionary->abbreviation = $request->abbreviation;
        $dictionary->word = $request->word;
        $dictionary->save();

        return "Singkatan berhasil dimasukkan";
    }
}