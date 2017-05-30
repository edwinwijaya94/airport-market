<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Route for Categories
Route::get('/virtualmarket/categories', 'CategoryController@getAllCategory');
Route::post('/virtualmarket/categories/add', 'CategoryController@addCategory');
Route::post('/virtualmarket/categories/edit/{id}', 'CategoryController@updateCategory');

//Route for Unit
Route::get('/virtualmarket/units', 'UnitController@getAllUnit');
Route::get('/virtualmarket/units/{id}', 'UnitController@getUnit');
Route::post('/virtualmarket/units/add', 'UnitController@addUnit');
Route::post('/virtualmarket/units/edit/{id}', 'UnitController@updateUnit');

//Route for Converter
Route::get('/virtualmarket/converter', 'ConverterController@getAllConverter');
Route::get('/virtualmarket/converter/{id}', 'ConverterController@getConverter');
Route::get('/virtualmarket/converter/add/{unit_id}/{gram}', 'ConverterController@addConverter');
Route::get('/virtualmarket/converter/edit/{unit_id}/{gram}', 'ConverterController@updateConverter');

//Route for Products
Route::get('/virtualmarket/categories/{id}', 'ProductController@getAllProductByCategory');
Route::get('/virtualmarket/product', 'ProductController@getAllProduct');
Route::get('/virtualmarket/product/{id}', 'ProductController@getProduct');
Route::get('/virtualmarket/product/search/{keyword}', 'ProductController@getSearchProduct');
Route::post('/virtualmarket/product/add', 'ProductController@addProduct');
Route::post('/virtualmarket/product/edit/{id}', 'ProductController@updateProduct');

//Route for Order
Route::get('/virtualmarket/order', 'OrderController@getAllOrder');
Route::get('/virtualmarket/order/{id}', 'OrderController@getOrder');
Route::post('/virtualmarket/order/add', 'OrderController@addOrder');

//Route for Order Line
Route::get('/virtualmarket/orderline', 'OrderLineController@getAllOrderLine');
Route::post('/virtualmarket/order/add/{id}', 'OrderLineController@addOrderLine');

//Route for Order Status
Route::get('/virtualmarket/status', 'OrderStatusController@getStatus');
Route::get('/virtualmarket/status/{id}', 'OrderStatusController@getOrderStatus');

//Route for image
Route::get('/virtualmarket/images/{categories}/{filename}', function($categories, $filename){
    $path = public_path('images/') . $categories . '/' . $filename;

    if(!File::exists($path)) {
        return response()->json(['message' => 'Image not found.'], 404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});
