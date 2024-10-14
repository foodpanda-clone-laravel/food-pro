<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\OrderController;



Route::middleware(['request.logs', 'jwt'])->group(function () {

  // Customer-related routes
  Route::prefix('customers')->group(function () {
    Route::controller(CustomerController::class)->group(function () {
      Route::patch('edit-profile', 'editProfile');
      Route::get('favorites', 'favoriteItems');
      Route::get('rewards', 'viewRewards');
      Route::post('use-points', 'usePointsAtCheckout');
      Route::patch('update-address', 'updateCustomerAddress')->name('updateCustomerAddress');
      Route::get('profile', 'viewProfile');
      Route::post('favorite-restaurants', 'addFavoriteRestaurant');
      Route::delete('favorite-restaurants', 'removeFavoriteRestaurant');
      Route::post('feedback', 'submitFeedback');
      Route::get('menus', 'viewMenus');
      Route::get('search-restaurant', 'searchRestaurant');
      Route::get('restaurants', 'viewAllRestaurants');
      Route::get('deals', 'viewDeals');
    });
  });

  // Order-related routes
  Route::prefix('orders')->group(function () {
    Route::controller(OrderController::class)->group(function () {
      Route::get('history', 'orderHistory');
      Route::get('active-order', 'activeOrder');
    });

  });
});

/***
 * 
    // Customer-related routes
    Route::prefix('customers')->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::patch('edit-profile', 'editProfile');
            Route::get('favorites', 'favoriteItems');
            Route::get('rewards', 'viewRewards');
            Route::post('use-points', 'usePointsAtCheckout');
            Route::patch('update-address', 'updateCustomerAddress')->name('updateCustomerAddress');
            Route::get('profile', 'viewProfile');
            Route::post('favorite-restaurants', 'addFavoriteRestaurant');
            Route::delete('favorite-restaurants', 'removeFavoriteRestaurant');
            Route::post('feedback', 'submitFeedback');
            Route::get('menus', 'viewMenus');
            Route::get('search-restaurant', 'searchRestaurant');
            Route::get('restaurants', 'viewAllRestaurants');
            Route::get('deals', 'viewDeals');
        });
    });

    // Order-related routes
    Route::prefix('orders')->group(function () {
        Route::controller(OrderController::class)->group(function () {
            Route::get('history', 'orderHistory');
            Route::get('active-order', 'activeOrder');
        });

    });
 * 
 * 
 */