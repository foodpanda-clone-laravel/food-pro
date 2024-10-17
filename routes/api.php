<?php

use App\Http\Controllers\Orders\CartController;
use App\Http\Controllers\RestaurantOwner\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
// use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\Restaurant\RestaurantController;




require __DIR__ . '/hibacustomerRoutes/customer.php';
require __DIR__ . '/restaurant/restaurantapi.php';
require __DIR__ . '/order/orderapi.php';
require __DIR__ . '/Customer/customerapi.php';
require __DIR__ . '/Admin/admin.php';
require __DIR__ . '/Menu/menu.php';
Route::controller(RegisterController::class)->group(function () {
    Route::post('submit-restaurant-request','submitRestaurantRequest');
    Route::post('/register', 'signup');
    Route::post('/register-business', 'registerRestaurantWithOwner');

Route::post('/register', [RegisterController::class, 'signup']);
Route::post('/register-business', [RegisterController::class, 'registerRestaurantWithOwner']);

// Test user route (authenticated)
Route::get('/user', function (Request $request) {
    return response()->json($request->auth);


    //Route::post('/reset-password', 'submitResetPasswordForm')->name('password.update');
});
Route::controller(CartController::class)->group(function () {
    Route::get('/session', 'getShoppingSession');
});


Route::post('create-menu/{branch_id}', [MenuController::class, 'createMenu']);
Route::post('add-item/menu/{menu_id}', [MenuController::class, 'addMenuItem']);
Route::post('add-addon/menu/{menu_item_id}', [MenuController::class, 'addOns']);
Route::post('update-menu/{menu_item}', [MenuController::class, 'updateMenu']);
Route::post('update-menu-item/{menu_item_id}', [MenuController::class, 'updateMenuItem']);
Route::post('add-choice/{menu_id}', [MenuController::class, 'storeChoices']);

});
Route::controller(UserController::class)->group(function () {
    Route::post('/login','login');
    Route::post('/logout',  'logout');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'submitForgotPasswordForm')->name('password.email');
    Route::post('/reset-password', 'submitResetPasswordForm')->name('password.update');
});


Route::controller(CartController::class)->group(function () {
    Route::get('/session', 'getShoppingSession');
});
