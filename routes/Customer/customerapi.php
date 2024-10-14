<?php

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OrderController;
use Illuminate\Support\Facades\Route;
Route::controller(OrderController::class)->group(function () {
   Route::get('/checkout-order-summary', 'checkout');
   Route::post('/checkout', 'createOrder');
});

Route::controller(CustomerController::class)->group(function () {
   Route::get('/restaurant', 'viewRestaurantById');
});
