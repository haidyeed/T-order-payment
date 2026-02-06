<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::post("register",[UserController::class,'register']);

Route::post('login', [UserController::class,'login'])->name('login');

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');

});