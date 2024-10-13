<?php

use App\Http\Controllers\Orders\CartController;
use App\Http\Middleware\APIRequestLogsMiddleware;
use Illuminate\Support\Facades\Route;

Route::controller(CartController::class)->group(function () {
    Route::post('add-to-cart', 'addToCart');
    Route::get('cart', 'viewMyCart');
    Route::get('update-cart', 'updateCart');
});


