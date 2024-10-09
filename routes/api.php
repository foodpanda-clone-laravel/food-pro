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

Route::middleware('request.logs')->group(function () {
    Route::get('/hi', function () {
        throw new Error(400, 'dslfjlksdf');
        ApiRequestLog::create();

    });
});

// Grouped routes for customer-related actions
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
    Route::get('customers/{customerId}', [CustomerController::class, 'viewProfile']);

    // Add a restaurant to the customer's favorite list
    Route::post('customers/{customerId}/favorite-restaurants', [CustomerController::class, 'addFavoriteRestaurant']);

    // Remove a restaurant from the customer's favorite list
    Route::delete('customers/{customerId}/favorite-restaurants/{restaurantId}', [CustomerController::class, 'removeFavoriteRestaurant']);

    // View the customer’s current active order
    Route::get('customers/{customerId}/active-order', [CustomerController::class, 'activeOrder']);

    // Submit feedback or review for an order/restaurant
    Route::post('customers/{customerId}/feedback', [CustomerController::class, 'submitFeedback']);
});

// View all menus (does not depend on customer ID)
Route::get('menus', [CustomerController::class, 'viewMenus']);

// Search for a restaurant
Route::get('search-restaurant', [CustomerController::class, 'searchRestaurant']);
Route::middleware(['jwt'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->auth);
    });
});
Route::middleware('request.logs')->group(function () {

});
