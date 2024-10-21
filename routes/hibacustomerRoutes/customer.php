<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\ProfileController;

// Publicly accessible routes
Route::controller(CustomerController::class)->group(function () {
  Route::get('search-restaurant', 'searchRestaurant');
  Route::get('restaurants', 'viewAllRestaurants');
  Route::get('restaurants/{restaurantId}/menus', 'viewMenus');
  Route::get('deals', 'viewDeals');
});


// Protected routes
Route::middleware(['request.logs', 'jwt'])->group(function () {

  // Customer-related routes
  Route::prefix('customers')->group(function () {
    Route::controller(CustomerController::class)->group(function () {
      Route::get('favorites', 'favoriteItems');
      Route::get('rewards', 'viewRewards');
      Route::post('use-points', 'usePointsAtCheckout');
      Route::post('add-favorite-restaurant', 'addFavoriteRestaurant');
      Route::delete('del-favorite-restaurant', 'removeFavoriteRestaurant');
      Route::post('feedback', 'submitFeedback');
    });

    //Customer profile relates
    Route::controller(ProfileController::class)->group(function () {
      Route::patch('edit-profile', 'editProfile');
      Route::patch('update-address', 'updateCustomerAddress')->name('updateCustomerAddress');
      Route::get('profile', 'viewProfile');
    });
  });

  // Order-related routes
  Route::prefix('orders')->group(function () {
    Route::controller(OrderController::class)->group(function () {
      Route::get('history', 'orderHistory');
      Route::get('active-order', 'activeOrder');
      Route::get('{order_id}/details', 'viewOrderDetails');
    });
  });
});
