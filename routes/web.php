<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

//Route for Categories
Route::get('virtualmarket/categories/add', 'CategoryController@imageUpload');

//Route for Unit
Route::get('virtualmarket/unit/add', 'UnitController@unitPost');

//Route for Products
Route::get('virtualmarket/products/add', 'ProductController@productAdd');

//Route for payment
Route::get('virtualmarket/pays', 'PaymentController@addPaymentFactor');