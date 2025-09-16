<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group( ['middleware' => ['auth:api']], function()
{   
    Route::get('/users','App\Http\Controllers\UserController@users');
    Route::resource('/user','App\Http\Controllers\UserController');
    Route::get('/checkAuth','App\Http\Controllers\AuthController@checkAuth');

    
    Route::get('/roles','App\Http\Controllers\RoleController@roles');

    Route::put('/change-email','App\Http\Controllers\AuthController@changeEmail');
    Route::put('/change-phone','App\Http\Controllers\AuthController@changePhone');

    Route::post('/confirm-email','App\Http\Controllers\AuthController@confirmEmail');
    Route::put('/update-user-profile','App\Http\Controllers\AuthController@updateUserProfile');
    Route::post('/confirm-phone','App\Http\Controllers\AuthController@confirmPhone');

    Route::post('/search/farm','App\Http\Controllers\FarmController@search');
    Route::get('/farms','App\Http\Controllers\FarmController@farms');
    Route::resource('/farm','App\Http\Controllers\FarmController');

    Route::post('/search/product','App\Http\Controllers\ProductController@search');
    Route::get('/products','App\Http\Controllers\ProductController@products');
    Route::resource('/product','App\Http\Controllers\ProductController');

    Route::post('/search/order','App\Http\Controllers\orderController@search');
    Route::get('/orders','App\Http\Controllers\OrderController@orders');
    Route::resource('/order','App\Http\Controllers\OrderController');

    Route::post('/search/orderitem','App\Http\Controllers\oredritemController@search');
    Route::get('/orderitems','App\Http\Controllers\OrderItemController@orderitems');
    Route::resource('/orderitem','App\Http\Controllers\OrderItemController');

    Route::post('/search/review','App\Http\Controllers\ReviewController@search');
    Route::get('/reviews','App\Http\Controllers\ReviewController@Reviews');
    Route::resource('/review','App\Http\Controllers\ReviewController');

    Route::post('/search/category','App\Http\Controllers\CategoryController@search');
    Route::get('/categories','App\Http\Controllers\CategoryController@categories');
    Route::resource('/category','App\Http\Controllers\CategoryController');

    Route::post('/search/delivery','App\Http\Controllers\DeliveryController@search');
    Route::get('/deliveries','App\Http\Controllers\DeliveryController@deliveries');
    Route::resource('/delivery','App\Http\Controllers\DeliveryController');
});

Route::post('/login','App\Http\Controllers\AuthController@login');

Route::post('/reset','App\Http\Controllers\AuthController@reset');
Route::post('/reset/save','App\Http\Controllers\AuthController@resetSave');
Route::post('/updatePassword','App\Http\Controllers\AuthController@updatePassword')->middleware('auth:api');
Route::get('/logout','App\Http\Controllers\AuthController@logout');