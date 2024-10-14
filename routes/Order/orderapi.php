<?php

use App\Http\Controllers\Orders\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Middleware\APIRequestLogsMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(CartController::class)->group(function () {
    Route::post('add-to-cart', 'addToCart');
    Route::get('cart', 'viewCart');
    Route::get('update-cart', 'updateCart');
    Route::get('cart-items-total','calculateItemsTotal');
    Route::get('total', 'calculateCartTotal');
});
