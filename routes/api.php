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

//Route for Users
Route::get('/user/all', 'UserController@getAllUser');
Route::post('/user', 'UserController@getUserByID');
Route::post('/user/register', 'UserController@addUser');
Route::post('/user/login', 'UserController@userLogin');
Route::post('/user/edit', 'UserController@updateUser');
Route::post('/shopper/register', 'UserController@addShopper');
Route::post('/shopper/login', 'UserController@shopperLogin');

//Route for Categories
Route::get('/categories', 'CategoryController@getAllCategory');
Route::post('/categories/add', 'CategoryController@addCategory');
Route::post('/categories/edit/{id}', 'CategoryController@updateCategory');
Route::post('/categories/delete/{id}', 'CategoryController@deleteCategory');

//Route for Products
Route::get('/categories/{id}', 'ProductController@getAllProductByCategory');
Route::get('/product', 'ProductController@getAllProduct');
Route::get('/product/{id}', 'ProductController@getProduct');
Route::get('/product/search/{keyword}', 'ProductController@getSearchProduct');
Route::post('/product/add', 'ProductController@addProduct');
Route::post('/product/edit/{id}', 'ProductController@updateProduct');
Route::post('/product/delete/{id}', 'ProductController@deleteProduct');

//Route for Order
Route::get('/order', 'OrderController@getAllOrder');
Route::post('/order/id', 'OrderController@getLastOrderID');
Route::get('/order/getData/{id}', 'OrderController@getOrderById');
Route::post('/order/add', 'OrderController@addOrder');
Route::post('/order/updateDeliveryStatus', 'OrderController@updateDeliveryStatus');
Route::post('/order/updateConfirmationStatus', 'OrderController@updateConfirmationStatus');
Route::get('/garendong', 'OrderController@getAllGarendong');
Route::post('/order/updatePriorityStatus', 'OrderController@updatePriorityStatus');    
 
//Route for Order Line
Route::get('/orderline', 'OrderLineController@getAllOrderLine');
Route::get('/orderline/{id}', 'OrderLineController@getOrderLinebyId');
Route::post('/order/add/{id}', 'OrderLineController@addOrderLine');
Route::post('/orderline/updatePrice', 'OrderLineController@updateProductPrice');
Route::post('/orderline/updateStatus', 'OrderLineController@updateStatus');
Route::post('/orderline/add', 'OrderLineController@addOrderLine');

//Route for Cart
Route::post('/cart', 'CartController@getCartByUserID');
Route::post('/cart/add', 'CartController@addCart');
Route::post('/cart/edit', 'CartController@editCartyByID');
Route::post('/cart/edit/priority', 'CartController@editPriorityByID');
Route::post('/cart/delete', 'CartController@deleteCartByID');
Route::post('/cart/remove', 'CartController@deleteCartByUserID');

//Route for Order Status
Route::get('/status', 'OrderStatusController@getAllSuccessStatus');
Route::get('/order/{id}', 'OrderController@getStateStatus');

//Route for Order Confirmation
Route::get('/confirmation/{id}', 'ConfirmationController@getDetailOrder');

//Route for Allocating Garendong
Route::get('/allocation', 'AllocationController@allocateGarendong');
Route::get('/allocationByDistance', 'AllocationController@allocateGarendongByDistance');
Route::get('/allocationKMeans', 'AllocationController@allocateGarendongKMeans');

//Route for image
Route::get('/images/{folder}/{filename}', 'ProductController@getImage');

//Route for payment
Route::get('/rates', 'PaymentController@countRates');
Route::get('/ratesById/{id}', 'PaymentController@countRatesById');
Route::get('/getAllRates', 'PaymentController@getAllRates');
Route::post('/updateRates', 'PaymentController@updateRates');
