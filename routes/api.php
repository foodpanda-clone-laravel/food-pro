<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Orders\CartController;


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

Route::post('/register', [RegisterController::class, 'signup']);
Route::post('/register-business', [RegisterController::class, 'registerRestaurantWithOwner']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware(['request.logs', 'jwt'])->group(function () {

    Route::prefix('customers')->group(function () {

        // View order history for a specific customer
        Route::get('{customerId}/orders', [CustomerController::class, 'orderHistory']);

        // View favorite restaurants for a specific customer
        Route::get('{customerId}/favorites', [CustomerController::class, 'favoriteItems']);

        // View rewards for a specific customer
        Route::get('{customerId}/rewards', [CustomerController::class, 'viewRewards']);

        // Use points at checkout for a specific customer
        Route::post('{customerId}/use-points', [CustomerController::class, 'usePointsAtCheckout']);

        // Update delivery address for a specific customer
        Route::patch('{customerId}/update-address', [CustomerController::class, 'updateDeliveryAddress']);

        // View customer profile details
        Route::get('{customerId}', [CustomerController::class, 'viewProfile']);

        // Add a restaurant to the customer's favorite list
        Route::post('{customerId}/favorite-restaurants', [CustomerController::class, 'addFavoriteRestaurant']);

        // Remove a restaurant from the customer's favorite list
        Route::delete('{customerId}/favorite-restaurants/{restaurantId}', [CustomerController::class, 'removeFavoriteRestaurant']);

        // View the customer’s current active order
        Route::get('{customerId}/active-order', [CustomerController::class, 'activeOrder']);

        // Submit feedback or review for an order/restaurant
        Route::post('{customerId}/feedback', [CustomerController::class, 'submitFeedback']);
    });



    // View all menus (does not depend on customer ID)
    Route::get('menus', [CustomerController::class, 'viewMenus']);

    // Search for a restaurant
    Route::get('search-restaurant', [CustomerController::class, 'searchRestaurant']);

    // Test user route (authenticated)
    Route::get('/user', function (Request $request) {
        return response()->json($request->auth);
    });
    Route::controller(ForgotPasswordController::class)->group(function(){
        Route::post('/forgot-password', 'submitForgotPasswordForm')->name('password.email');;
        Route::post('/reset-password', 'submitResetPasswordForm')->name('password.update');
    });
    Route::controller(CartController::class)->group(function(){
        Route::get('/session', 'getShoppingSession');
    });
});
