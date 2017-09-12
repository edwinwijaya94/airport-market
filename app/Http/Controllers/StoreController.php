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

class StoreController extends Controller {

    public function getAllStoreByCategory(Request $request, $id) {
    	//retrieve all stores based on cateory
    	$stores = Category::find($id)->stores;

        foreach($stores as $store) {
            $store->name = ucwords($store->name);
        }

    	return Response::json(array(
    		'error'=> false,
    		'stores'=> $stores->toArray()),
    		200
    	);
    }

    public function getAllStore(Request $request) {
        //retrieve all stores from database
        $stores = Store::all();
        foreach($stores as $store) {
            $store->name = ucwords($store->name);
        }

        return Response::json(array(
            'error'=>false,
            'stores'=> $stores->toArray()),
            200
        );
    }

    public function getStore(Request $request, $id) {
        //retrieve store based on id from database
    	$detail = Product::find($id);
        $detail->default_unit_id = $detail->unit->unit;
        $detail->name = ucwords($detail->name);

    	return Response::json(array(
    		'error'=>false,
    		'detail'=>$detail),
    		200
    	);
    }

    public function getSearchStore(Request $request, $keyword) {
        //retrieve store based on key word from user
        $results = Store::where('name', 'ILIKE', '%'.$keyword.'%')->get();
        foreach($results as $result)
            $result->default_unit_id = $result->unit->unit;
            $result->name = ucwords($result->name);

        return Response::json(array(
            'error'=>false,
            'stores'=>$results->toArray()),
            200
        );
    }

    public function getImage($folder, $filename) {
        //retrieve image from file
        $path = public_path('images/') . $folder . '/' . $filename;

        if(!File::exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function addStore(Request $request) {

        //add image to folder images
        $fileImage = $request->store_image;
        $imageName = time().'_'.$fileImage->getClientOriginalName();
        $fileImage->move(public_path('images/stores'), $imageName);

        //add store to database
    	$store = new Store();
    	$store->name = strtolower($request->store_name);
    	$store->store_img = $imageName;
    	$store->category_id = $request->category_id;
        $store->save();

        return Response::json(array(
    		'error'=>false,
    		'message'=>"Store berhasil ditambahkan"),
    		200
    	);
    }

    public function updateStore(Request $request, $id) {

        // image section
        $store = Store::find($id);
        $oldImage = $store->product_img;
        // check images update or not
        $isChangeImage = $request->isChangeImage;
        if($isChangeImage) {
            //delete old image
            $pathFile = public_path('images/stores/') . $oldImage;
            File::delete($pathFile);
            //add image to folder images
            $fileImage = $request->product_image;
            $imageName = time().'_'.$fileImage->getClientOriginalName();
            $fileImage->move(public_path('images/stores/'), $imageName);
        } else {
            $imageName = $oldImage;
        }
        //add store to database
        $store->name = strtolower($request->store_name);
        $store->store_img = $imageName;
        $store->category_id = $request->category_id;
        $store->save();

        return Response::json(array(
            'error'=>false,
            'message'=>"Store berhasil diubah"),
            200
        );
    }

    public function deleteStore($id) {
        //delete data of store from database
        $store = Store::find($id);
        $oldImage = $store->store_img;
        //delete image
        $pathFile = public_path('images/stores/') . $oldImage;
        File::delete($pathFile);
        $Store->delete();

        return Response::json(array(
            'error'=>false,
            'message'=>"Store berhasil dihapus"),
            200
        );
    }
}

