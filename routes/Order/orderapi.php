<?php

use App\GlobalVariables\PermissionVariables;
use App\Http\Controllers\Orders\CartController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Orders\OrderDashboardController;
use App\Http\Middleware\APIRequestLogsMiddleware;

use Illuminate\Support\Facades\Route;
Route::middleware([ 'jwt', 'routes.permissions'])->group(function () {


Route::controller(CartController::class)->group(function () {
    Route::post(PermissionVariables::$addToCart['path'], 'addToCart');
    Route::get(PermissionVariables::$viewCart['path'], 'viewCart');
    Route::get(PermissionVariables::$updateCart['path'], 'updateCart');
    Route::get(PermissionVariables::$cartItemsTotal['path'],'calculateItemsTotal');
    Route::get(PermissionVariables::$cartTotal['path'], 'calculateCartTotal');
});
Route::middleware('auth:api')->group(function () {
    Route::get(PermissionVariables::$viewRestaurantOrders['path'], [OrderDashboardController::class, 'index']);
    Route::post(PermissionVariables::$updateOrderStatus['path'], [OrderDashboardController::class, 'updateOrderStatus']);
});



    });

