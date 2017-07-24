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

//Login and Logour
Route::post('/virtualmarket/login', 'UserController@login');
Route::get('/virtualmarket/logout', 'UserController@logout');

//Route for Users
Route::get('/virtualmarket/user/all', 'UserController@getAllUser');
Route::get('/virtualmarket/user/role', 'UserController@getBuyerRoleID');
Route::post('/virtualmarket/user', 'UserController@getUserByID');
Route::post('/virtualmarket/user/register', 'UserController@addUser');
Route::post('/virtualmarket/user/login', 'UserController@userLogin');
Route::post('/virtualmarket/user/edit', 'UserController@updateUser');
Route::post('/virtualmarket/garendong/register', 'UserController@addGarendong');

//Route for Categories
Route::get('/virtualmarket/categories', 'CategoryController@getAllCategory');
Route::post('/virtualmarket/categories/add', 'CategoryController@addCategory');
Route::post('/virtualmarket/categories/edit/{id}', 'CategoryController@updateCategory');
Route::post('/virtualmarket/categories/delete/{id}', 'CategoryController@deleteCategory');

//Route for Unit
Route::get('/virtualmarket/units', 'UnitController@getAllUnit');
Route::get('/virtualmarket/units/common', 'UnitController@getCommonUnit');
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
Route::post('/virtualmarket/order/id', 'OrderController@getLastOrderID');
Route::post('/virtualmarket/order/add', 'OrderController@addOrder');
Route::post('/virtualmarket/order/updateDeliveryStatus', 'OrderController@updateDeliveryStatus');
Route::post('/virtualmarket/order/updateConfirmationStatus', 'OrderController@updateConfirmationStatus');
Route::get('/virtualmarket/garendong', 'OrderController@getAllGarendong');

//Route for Order Line
Route::get('/virtualmarket/orderline', 'OrderLineController@getAllOrderLine');
Route::get('/virtualmarket/orderline/{id}', 'OrderLineController@getOrderLinebyId');
Route::post('/virtualmarket/orderline/add', 'OrderLineController@addOrderLine');
Route::post('/virtualmarket/orderline/updatePrice', 'OrderLineController@updateProductPrice');
Route::post('/virtualmarket/orderline/updateStatus', 'OrderLineController@updateStatus');

//Route for Shopping List
Route::post('/virtualmarket/cart', 'CartController@getCartByUserID');
Route::post('/virtualmarket/cart/count', 'CartController@getCountCart');
Route::post('/virtualmarket/cart/add', 'CartController@addCart');
Route::post('/virtualmarket/cart/edit', 'CartController@editCartByID');
Route::post('/virtualmarket/cart/edit/priority', 'CartController@editPriorityByID');
Route::post('/virtualmarket/cart/delete', 'CartController@deleteCartByID');
Route::post('/virtualmarket/cart/remove', 'CartController@deleteCartByUserID');

//Route for Order Status
Route::get('/virtualmarket/status', 'OrderStatusController@getAllStatus');
Route::get('/virtualmarket/order/{id}', 'OrderController@getStateStatus');

//Route for Reason
Route::get('/virtualmarket/reasons', 'ReasonController@getAllReasons');

//Route for Feedback
Route::get('/virtualmarket/feedback/history', 'OrderController@getOrderHistory');
Route::post('/virtualmarket/rating/add', 'OrderController@addRating');
Route::post('/virtualmarket/feedback/add', 'UserFeedbackController@addFeedback');
Route::get('/virtualmarket/feedback', 'UserFeedbackController@getAllFeedback');

//Route for Order Confirmation
Route::get('/virtualmarket/confirmation/{id}', 'ConfirmationController@getDetailOrder');

//Route for Allocating Garendong
Route::get('/virtualmarket/allocation', 'AllocationController@allocateGarendong');
Route::get('/virtualmarket/allocationByDistance', 'AllocationController@allocateGarendongByDistance');

//Route for image
Route::get('/virtualmarket/images/{folder}/{filename}', 'ProductController@getImage');

//Route for payment
Route::get('/virtualmarket/rates', 'PaymentController@countRates');
Route::get('/virtualmarket/ratesById/{id}', 'PaymentController@countRatesById');

//Route for SMS
Route::get('virtualmarket/sms/all', 'SMSController@getAllSMS');
// Route::get('/sms/send', 'SMSController@sendMessage');
Route::post('virtualmarket/sms/receive', 'SMSController@receiveMessage');


//Route for Dictionary
Route::get('virtualmarket/dictionary', 'DictionaryController@getAllDictionary');
Route::post('virtualmarket/dictionary/add', 'DictionaryController@addDictionary');

//Route for Undefine Word
Route::get('virtualmarket/undefine/word', 'UndefineWordController@getAllUndefineWord');
