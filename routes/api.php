<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//Route::group(['middleware' => 'auth:api'], function() {

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{pid}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{pid}', [ProductController::class, 'update']);

    //Cart
    Route::get('/cart-items', [CartController::class, 'index']);
    Route::post('/cart-items', [CartController::class, 'store']);
    Route::delete('/cart-items/{pid}', [CartController::class, 'destroy']);

    // Product Categories
    Route::get('/category/{cid}/products', [CategoryController::class, 'index']);

    // Orders
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{oid}', [OrderController::class, 'show']);
    Route::post('/orders', [OrderController::class, 'store']);

//});
