<?php

use App\Http\Controllers\Orders\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Menu\MenuController;

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
        Route::controller(CustomerController::class)->group(function () {
            Route::get('orders', 'orderHistory');
            Route::get('favorites', 'favoriteItems');
            Route::get('rewards', 'viewRewards');
            Route::post('use-points', 'usePointsAtCheckout');
            Route::patch('update-address', 'updateCustomerAddress')->name('updateCustomerAddress');
            Route::get('profile', 'viewProfile');
            Route::post('favorite-restaurants', 'addFavoriteRestaurant');
            Route::delete('favorite-restaurants', 'removeFavoriteRestaurant');
            Route::get('active-order', 'activeOrder');
            Route::post('feedback', 'submitFeedback');
            Route::get('menus', 'viewMenus');
            Route::get('search-restaurant', 'searchRestaurant');
            Route::get('restaurants', 'viewAllRestaurants');
        });
    });


    // Test user route (authenticated)
    Route::get('/user', function (Request $request) {
        return response()->json($request->auth);

    });
    Route::post('create-menu/{branch_id}', [MenuController::class, 'createMenu']);
    Route::post('add-item/menu/{menu_id}', [MenuController::class, 'addMenuItem']);
    Route::post('add-addon/menu/{menu_item_id}', [MenuController::class, 'addOns']);
    Route::post('update-menu/{menu_item}', [MenuController::class, 'updateMenu']);
    Route::post('update-menu-item/{menu_item_id}', [MenuController::class, 'updateMenuItem']);
    Route::post('add-choice/{menu_id}', [MenuController::class, 'storeChoices']);

    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::post('/forgot-password', 'submitForgotPasswordForm')->name('password.email');

        Route::post('/reset-password', 'submitResetPasswordForm')->name('password.update');
    });
    Route::controller(CartController::class)->group(function () {
        Route::get('/session', 'getShoppingSession');
    });
});
