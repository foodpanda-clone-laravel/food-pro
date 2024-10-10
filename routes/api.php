<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\RestaurantOwner\RestaurantController;
use App\Http\Controllers\Auth\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('/restaurant/register-with-owner', [RestaurantController::class, 'registerRestaurantWithOwner']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['request.logs', 'jwt'])->group(function () {


    // Grouped routes for customer-related actions
    Route::prefix('customers')->group(function () {

        Route::controller(CustomerController::class)->group(function () {

            // View order history for a specific customer
            Route::get('{customerId}/orders', 'orderHistory');

            // View favorite restaurants for a specific customer
            Route::get('{customerId}/favorites', 'favoriteItems');

            // View rewards for a specific customer
            Route::get('{customerId}/rewards', 'viewRewards');

            // Use points at checkout for a specific customer
            Route::post('{customerId}/use-points', 'usePointsAtCheckout');

            // Update delivery address for a specific customer
            Route::patch('{customerId}/update-address', 'updateDeliveryAddress');

            // View customer profile details
            Route::get('{customerId}', 'viewProfile');

            // Add a restaurant to the customer's favorite list
            Route::post('{customerId}/favorite-restaurants', 'addFavoriteRestaurant');

            // Remove a restaurant from the customer's favorite list
            Route::delete('{customerId}/favorite-restaurants/{restaurantId}', 'removeFavoriteRestaurant');

            // View the customer’s current active order
            Route::get('{customerId}/active-order', 'activeOrder');

            // Submit feedback or review for an order/restaurant
            Route::post('{customerId}/feedback', 'submitFeedback');

            // View all menus (does not depend on customer ID)
            Route::get('menus', 'viewMenus');

            // Search for a restaurant
            Route::get('search-restaurant', 'searchRestaurant');

            // View all restaurants (does not depend on customer ID)
            Route::get('restaurants', 'viewAllRestaurants');
        });

    });








    // Test user route (authenticated)
    Route::get('/user', function (Request $request) {
        return response()->json($request->auth);

    });

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::post('/forgot-password', 'submitForgotPasswordForm')->name('password.email');
        ;
        Route::post('/reset-password', 'submitResetPasswordForm')->name('password.update');
    });

});

