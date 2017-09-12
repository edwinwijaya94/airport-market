<?php

namespace App\Http\Controllers;

use App\Product;
use App\Category;
use App\Unit;
use App\Converter;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Response;
use File;

class ProductController extends Controller {

    public function getAllProductByStore(Request $request, $id) {
    	//retrieve all products based on store
    	$products = Store::find($id)->products;

        foreach($products as $product) {
            $product->name = ucwords($product->name);
        }

    	return Response::json(array(
    		'error'=> false,
    		'products'=> $products->toArray()),
    		200
    	);
    }

    public function getAllProduct(Request $request) {
        //retrieve all products from database
        $products = Product::all();
        foreach($products as $product) 
            $product->name = ucwords($product->name);

        return Response::json(array(
            'error'=>false,
            'products'=> $products->toArray()),
            200
        );
    }

    public function getProduct(Request $request, $id) {
        //retrieve product based on id from database
    	$detail = Product::find($id);
        $detail->name = ucwords($detail->name);

    	return Response::json(array(
    		'error'=>false,
    		'detail'=>$detail),
    		200
    	);
    }

    public function getSearchProductByStore(Request $request, $keyword) {
        //retrieve product based on key word from user
        $results = Product::where('name', 'ILIKE', '%'.$keyword.'%')
                    ->where('store_id','=',$request->store_id)
                    ->get();
        foreach($results as $result)
            $result->name = ucwords($result->name);

        return Response::json(array(
            'error'=>false,
            'products'=>$results->toArray()),
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

    public function addProduct(Request $request) {
        $price = round($request->price);

        //add image to folder images
        $fileImage = $request->product_image;
        $imageName = time().'_'.$fileImage->getClientOriginalName();
        $fileImage->move(public_path('images/products'), $imageName);

        //add product to database
    	$product = new Product();
    	$product->name = strtolower($request->product_name);
    	$product->product_img = $imageName;
    	$product->store_id = $request->store_id;
        $product->save();

        return Response::json(array(
    		'error'=>false,
    		'message'=>"Produk berhasil ditambahkan"),
    		200
    	);
    }

    public function updateProduct(Request $request, $id) {
        
        $price = round($request->price); //round price
        // image section
        $product = Product::find($id);
        $oldImage = $product->product_img;
        // check images update or not
        $isChangeImage = $request->isChangeImage;
        if($isChangeImage) {
            //delete old image
            $pathFile = public_path('images/products/') . $oldImage;
            File::delete($pathFile);
            //add image to folder images
            $fileImage = $request->product_image;
            $imageName = time().'_'.$fileImage->getClientOriginalName();
            $fileImage->move(public_path('images/products/'), $imageName);
        } else {
            $imageName = $oldImage;
        }
        //add product to database
        $product->name = strtolower($request->product_name);
        $product->product_img = $imageName;
        $product->store_id = $request->store_id;
        $product->save();

        return Response::json(array(
            'error'=>false,
            'message'=>"Produk berhasil diubah"),
            200
        );
    }

    public function deleteProduct($id) {
        //delete data of prorduct from database
        $product = Product::find($id);
        $oldImage = $product->product_img;
        //delete image
        $pathFile = public_path('images/products/') . $oldImage;
        File::delete($pathFile);
        $product->delete();

        return Response::json(array(
            'error'=>false,
            'message'=>"Produk berhasil dihapus"),
            200
        );
    }
}

