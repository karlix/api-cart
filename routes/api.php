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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cart/{idCart}/total-products', "App\Http\Controllers\Api\CartController@getTotalProducts")->name("cart.total");
Route::get('/cart/{idCart}', "App\Http\Controllers\Api\CartController@getCart")->name("cart.get");

Route::put('/cart/{idCart}/add', "App\Http\Controllers\Api\CartController@addToCart")->name("cart.add");
Route::put('/cart/{idCart}/remove', "App\Http\Controllers\Api\CartController@removeFromCart")->name("cart.remove");
Route::put('/cart/{idCart}/clear', "App\Http\Controllers\Api\CartController@clear")->name("cart.clear");
Route::put('/cart/{idCart}/confirm', "App\Http\Controllers\Api\CartController@confirmPurchase")->name("cart.confirm");

Route::delete('/cart/{idCart}', "App\Http\Controllers\Api\CartController@delete")->name("cart.delete");

Route::post('/cart', "App\Http\Controllers\Api\CartController@create")->name("cart.create");
