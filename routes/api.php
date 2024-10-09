<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\APIRequestLogsMiddleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;
use App\Models\ApiRequestLog;
use App\Http\Controllers\CustomerController;

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RestaurantController;
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
use App\Http\Controllers\UserController;

Route::middleware(['request.logs', 'jwt'])->group(function () {

    // Group all customer-related actions under the CustomerController
    Route::controller(CustomerController::class)->group(function () {

        Route::prefix('customers')->group(function () {
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
        });

        // View all menus (does not depend on customer ID)
        Route::get('menus', 'viewMenus');

        // Search for a restaurant
        Route::get('search-restaurant', 'searchRestaurant');
    });

    // Test authenticated user route
    Route::get('/user', function (Request $request) {
        return response()->json($request->auth);
    });

});
Route::middleware('request.logs')->group(function () {

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::post('/forgot-password', 'submitForgotPasswordForm')->name('password.email');
        ;
        Route::post('/reset-password', 'submitResetPasswordForm')->name('password.update');
    });

});


