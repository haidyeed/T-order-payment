<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


Route::post("register",[UserController::class,'register'])->name('register');

Route::post('login', [UserController::class,'login'])->name('login');
        // Route::get('/order/changeStatus/{id}/{status}', [OrderController::class, 'changeOrderStatus'])->name('change-order-status');

Route::group(['middleware' => 'auth:api'], function(){

    //User routes
    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

    //Product routes
    Route::get('/products', [ProductController::class, 'viewProducts'])->name('view.products'); 
    Route::post('/products', [ProductController::class, 'store'])->name('store.product');

    //Order routes
    Route::get('/orders', [OrderController::class, 'viewOrders'])->name('view.orders'); 
    Route::get('/order/{id}', [OrderController::class, 'viewOrderDetails'])->name('view.order');

    Route::post('/orders', [OrderController::class, 'createOrder'])->name('create.order');
    Route::get('/order/changeStatus/{id}/{status}', [OrderController::class, 'changeOrderStatus'])->name('change-order-status');


});