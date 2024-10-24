<?php

use Illuminate\Support\Facades\Route;
use App\GlobalVariables\PermissionVariables;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OrderController;

// Publicly accessible routes
Route::controller(CustomerController::class)->group(function () {
    Route::get(PermissionVariables::$viewAllRestaurants['path'], 'viewAllRestaurants');
  Route::get(PermissionVariables::$searchRestaurant['path'], 'searchRestaurant');
  Route::get(PermissionVariables::$viewMenus['path'], 'viewMenus');
  Route::get(PermissionVariables::$viewDeals['path'], 'viewDeals');
});



// Protected routes
Route::middleware(['jwt', 'routes.permissions'])->group(function () {
  // Customer-related routes
  Route::prefix('customers')->group(function () {
    Route::controller(CustomerController::class)->group(function () {

      Route::get(PermissionVariables::$favoriteItems['path'], 'favoriteItems');
      Route::get(PermissionVariables::$viewRewards['path'], 'viewRewards');
      Route::post(PermissionVariables::$usePointsAtCheckout['path'], 'usePointsAtCheckout');
      Route::post(PermissionVariables::$addFavoriteRestaurant['path'], 'addFavoriteRestaurant');
      Route::delete(PermissionVariables::$removeFavoriteRestaurant['path'], 'removeFavoriteRestaurant');
      Route::post(PermissionVariables::$submitFeedback['path'], 'submitFeedback');
    });
    Route::controller(ProfileController::class)->group(function () {
      Route::patch(PermissionVariables::$editProfile['path'], 'editProfile');
      Route::patch(PermissionVariables::$updateCustomerAddress['path'], 'updateCustomerAddress')->name('updateCustomerAddress');
      Route::get(PermissionVariables::$viewProfile['path'], 'viewProfile');
    });
  });

  // Order-related routes
  Route::prefix('orders')->group(function () {
    Route::controller(OrderController::class)->group(function () {
      Route::get(PermissionVariables::$myOrderHistory['path'], 'orderHistory');
      Route::get(PermissionVariables::$activeOrder['path'], 'activeOrder');
      Route::get(PermissionVariables::$viewCustomerOrderDetails['path'], 'viewOrderDetails');
    });
  });

});
