<?php

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\ProfileController;

Route::middleware([ 'jwt', 'routes.permissions'])->group(function () {

    Route::controller(OrderController::class)->group(function () {
        Route::get('/checkout-order-summary', 'checkout');
        Route::post('/checkout', 'createOrder');
    });

    Route::controller(CustomerController::class)->group(function () {
        Route::get('/restaurant', 'viewRestaurantById');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::post('/change-password', 'changePassword');
    });
});
