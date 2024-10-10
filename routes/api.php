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
    Route::prefix('customers')->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::get('{customerId}/orders', 'orderHistory');
            Route::get('{customerId}/favorites', 'favoriteItems');
            Route::get('{customerId}/rewards', 'viewRewards');
            Route::post('{customerId}/use-points', 'usePointsAtCheckout');
            Route::patch('{customerId}/update-address', 'updateCustomerAddress')->name('updateCustomerAddress');
            Route::get('{customerId}', 'viewProfile');
            Route::post('{customerId}/favorite-restaurants', 'addFavoriteRestaurant');
            Route::delete('{customerId}/favorite-restaurants/{restaurantId}', 'removeFavoriteRestaurant');
            Route::get('{customerId}/active-order', 'activeOrder');
            Route::post('{customerId}/feedback', 'submitFeedback');
            Route::get('menus', 'viewMenus');
            Route::get('search-restaurant', 'searchRestaurant');
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

