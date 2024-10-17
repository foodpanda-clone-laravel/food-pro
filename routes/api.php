<?php

use App\Http\Controllers\Orders\CartController;
use App\Http\Controllers\RestaurantOwner\MenuController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\RegisterController;



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
