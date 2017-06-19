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

    public function productAdd() {
        return view('product');
    }

    public function getAllProductByCategory(Request $request, $id) {
    	//retrieve all products based on cateory
    	$products = Category::find($id)->products;
        foreach($products as $product)
            $product->default_unit_id = $product->unit->unit;

    	return Response::json(array(
    		'error'=> false,
    		'products'=> $products->toArray()),
    		200
    	);
    }

    public function getAllProduct(Request $request) {
        //retrieve all products from database
        $products = Product::all();

        return Response::json(array(
            'error'=>false,
            'products'=> $products->toArray()),
            200
        );
    }

    public function getProduct(Request $request, $id) {
        //retrieve product based on id from database
    	$detail = Product::find($id);
        $detail->default_unit_id = $detail->unit->unit;

    	return Response::json(array(
    		'error'=>false,
    		'detail'=>$detail),
    		200
    	);
    }

    public function getSearchProduct(Request $request, $keyword) {
        //retrieve product based on key word from user
        $results = Product::where('name', 'ILIKE', '%'.$keyword.'%')->get();
        foreach($results as $result)
            $result->default_unit_id = $result->unit->unit;

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
        //set default value
        $default_quantity = 100;
        // convert price to 100/gram
        $quantity = $request->product_quantity;
        $unit_id = $request->unit_id;
        $unit = Unit::find($unit_id);
        $converterObject = Converter::find($unit_id);
        // set default quantity based on unit type
        if ($unit->unit_type == 'common') {
            //search id for unit gram
            $unit_gram = DB::table('units')
                     ->where('unit', 'gram')
                     ->first();
            $default_unit = $unit_gram->id;
            $converter = $converterObject->in_gram;
            $quantity_in_gram = $quantity * $converter;
            $price = ($default_quantity/$quantity_in_gram) * $request->product_price;
        } else if ($unit->unit_type == 'uncommon')  {
            $default_quantity = 1;
            $default_unit = $unit_id;
            $price = ($default_quantity/$quantity) * $request->product_price;
        }
        $price = round($price);

        //add image to folder images
        $fileImage = $request->product_image;
        $imageName = time().'_'.$fileImage->getClientOriginalName();
        $fileImage->move(public_path('images/products'), $imageName);

        //add product to database
    	$product = new Product();
    	$product->name = $request->product_name;
    	$product->default_quantity = $default_quantity;
        $product->default_unit_id = $default_unit;
    	$product->price_min = $price;
        $product->price_max = $price;    	
    	$product->product_img = $imageName;
    	$product->category_id = $request->category_id;
        $product->save();

        return Response::json(array(
    		'error'=>false,
    		'message'=>"Produk berhasil ditambahkan"),
    		200
    	);
    }

    public function updateProduct(Request $request, $id) {
        //set default value
        $default_quantity = 100;
        // convert price to 100/gram
        $quantity = $request->product_quantity;
        $unit_id = $request->unit_id;
        $unit = Unit::find($unit_id);
        $converterObject = Converter::find($unit_id);
        if ($unit->unit_type == 'common') {
            //search id for unit gram
            $unit_gram = DB::table('units')
                     ->where('unit', 'gram')
                     ->first();
            $default_unit = $unit_gram->id;
            $converter = $converterObject->in_gram;
            $quantity_in_gram = $quantity * $converter;
            $price = ($default_quantity/$quantity_in_gram) * $request->product_price;
        } else if ($unit->unit_type == 'uncommon')  {
            $default_quantity = 1;
            $default_unit = $unit_id;
            $price = ($default_quantity/$quantity) * $request->product_price;
        }
        $price = round($price); //round price
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
        $product->name = $request->product_name;
        $product->default_quantity = $default_quantity;
        $product->default_unit_id = $default_unit;
        //compare price update with price in table for price min and price max
        if ($price < $product->price_min) {
            $product->price_min = $price;
        } else if ($price > $product->price_max) {
            $product->price_max = $price;
        }
        $product->product_img = $imageName;
        $product->category_id = $request->category_id;
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

