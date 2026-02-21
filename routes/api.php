<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UserController, PaymentController};
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


Route::post("register",[UserController::class,'register'])->name('register');

Route::post('login', [UserController::class,'login'])->name('login');

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
    Route::patch('/order/changeStatus/{id}/{status}', [OrderController::class, 'changeOrderStatus'])->name('change-order-status');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('delete.order');

    //Payment routes
    Route::post('/payments/orders/{id}', [PaymentController::class, 'processPayment'])->name('process.payment'); 
    Route::get('/payments', [PaymentController::class, 'viewPayments'])->name('view.payments'); 
    Route::get('/payments/orders/{id}', [PaymentController::class, 'viewPayments'])->name('view.order.payments');

});