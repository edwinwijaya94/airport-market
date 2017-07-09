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
Route::post('/virtualmarket/categories/delete/{id}', 'CategoryController@deleteCategory');

//Route for Unit
Route::get('/virtualmarket/units', 'UnitController@getAllUnit');
Route::get('/virtualmarket/units/{id}', 'UnitController@getUnit');
Route::post('/virtualmarket/units/add', 'UnitController@addUnit');
Route::post('/virtualmarket/units/edit/{id}', 'UnitController@updateUnit');
Route::post('/virtualmarket/units/delete/{id}', 'UnitController@deleteUnit');

//Route for Converter
Route::get('/virtualmarket/converter', 'ConverterController@getAllConverter');
Route::get('/virtualmarket/converter/{id}', 'ConverterController@getConverter');
Route::get('/virtualmarket/converter/add/{unit_id}/{gram}', 'ConverterController@addConverter');
Route::get('/virtualmarket/converter/edit/{unit_id}/{gram}', 'ConverterController@updateConverter');
Route::get('/virtualmarket/converter/delete/{unit_id}', 'ConverterController@deleteConverter');

//Route for Products
Route::get('/virtualmarket/categories/{id}', 'ProductController@getAllProductByCategory');
Route::get('/virtualmarket/product', 'ProductController@getAllProduct');
Route::get('/virtualmarket/product/{id}', 'ProductController@getProduct');
Route::get('/virtualmarket/product/search/{keyword}', 'ProductController@getSearchProduct');
Route::post('/virtualmarket/product/add', 'ProductController@addProduct');
Route::post('/virtualmarket/product/edit/{id}', 'ProductController@updateProduct');
Route::post('/virtualmarket/product/delete/{id}', 'ProductController@deleteProduct');

//Route for Order
Route::get('/virtualmarket/order', 'OrderController@getAllOrder');
Route::get('/virtualmarket/order/getData/{id}', 'OrderController@getOrderById');
Route::post('/virtualmarket/order/add', 'OrderController@addOrder');
Route::post('/virtualmarket/order/updateDeliveryStatus', 'OrderController@updateDeliveryStatus');
Route::post('/virtualmarket/order/updateConfirmationStatus', 'OrderController@updateConfirmationStatus');


//Route for Order Line
Route::get('/virtualmarket/orderline', 'OrderLineController@getAllOrderLine');
Route::get('/virtualmarket/orderline/{id}', 'OrderLineController@getOrderLinebyId');
Route::post('/virtualmarket/order/add/{id}', 'OrderLineController@addOrderLine');
Route::post('/virtualmarket/orderline/updatePrice', 'OrderLineController@updateProductPrice');
Route::post('/virtualmarket/orderline/updateStatus', 'OrderLineController@updateStatus');

//Route for Order Status
Route::get('/virtualmarket/status', 'OrderStatusController@getAllStatus');
Route::get('/virtualmarket/state-status/{id}', 'OrderController@getStateStatus');

//Route for Reason
Route::get('/virtualmarket/reasons', 'ReasonController@getAllReasons');

//Route for Feedback
Route::get('/virtualmarket/feedback/history', 'OrderController@getOrderHistory');
Route::post('/virtualmarket/rating/add', 'OrderController@addRating');
Route::post('/virtualmarket/feedback/add', 'UserFeedbackController@addFeedback');
Route::post('/virtualmarket/feedback', 'UserFeedbackController@getAllFeedback');

//Route for Order Confirmation
Route::get('/virtualmarket/confirmation/{id}', 'ConfirmationController@getDetailOrder');

//Route for Allocating Garendong
Route::get('/virtualmarket/allocation', 'AllocationController@allocateGarendong');

//Route for image
Route::get('/virtualmarket/images/{folder}/{filename}', 'ProductController@getImage');
