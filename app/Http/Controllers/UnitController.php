<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Converter;
use Illuminate\Http\Request;
use Response;

class UnitController extends Controller {
	
    public function unitPost() {
        return view('unit');
    }

	public function getAllUnit() {
    	//retrieve all unit from datbase
    	$units = Unit::all();
    	
    	return Response::json(array(
    		'units'=>$units->toArray()),
    		200
    	);
    }

    public function getUnit(Request $request, $id) {
        //retrieve unit based on id
        $unit = Unit::find($id);
        $converter = Converter::where('unit_id', $id)->first();
        
        return Response::json(array(
            'error'=>false,
            'unit'=>$unit,
            'converter' => $converter),
            200
        );
    }

    public function addUnit(Request $request) {
        //add unit to database
        $unit = new Unit();
        $unit->unit = $request->unit_name;
        $unit->unit_type = $request->unit_type;
        $convert_gram = $request->convert_gram;
        $unit->save();
        $unit_id = $unit->id;

        if($unit->unit_type == "common") {
            return redirect()->action('ConverterController@addConverter', ['unit_id' => $unit_id, 'gram' => $convert_gram ]);
        } else if($unit->unit_type == "uncommon") {
            return Response::json(array(
                'error'=>false,
                'message'=>"Unit berhasil ditambahkan"),
                200
            );
        }
    }

    public function updateUnit(Request $request, $id) {
        //update unit to database
        $unit = Unit::find($id);
        $unitOld = $unit->unit_type;
        $unitNow = $request->unit_type;
        $unit->unit = $request->unit_name;
        $unit->unit_type = $unitNow;
        $convert_gram = $request->convert_gram;
        $unit->save();
        //update based on unit type
        if ($unitOld == $unitNow) {
            if ($unit->unit_type == "common") {                
                return redirect()->action('ConverterController@updateConverter', ['unit_id' => $id, 'gram' => $convert_gram ]);
            }
        } if ($unitOld != $unitNow ) {
            if ($unitNow == "common") {
                return redirect()->action('ConverterController@addConverter', ['unit_id' => $id, 'gram' => $convert_gram ]);
            } else if ($unitNow == "uncommon") {
                //delete unit from converter
                return redirect()->action('ConverterController@deleteConverter', ['unit_id' => $id]);
            }
        }        
    }

    public function deleteUnit($id) {
        $unit = Unit::find($id);
        $unit->delete();
        if ($unit->unit_type == "common") {
            //delete converter
            return redirect()->action('ConverterController@deleteConverter', ['unit_id' => $id]);
        } else {
            return Response::json(array(
                'error'=>false,
                'message'=>"Unit berhasil dihapus"),
                200
            );
        }
    }
}
