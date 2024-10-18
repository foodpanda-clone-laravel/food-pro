<?php

use App\Http\Controllers\Orders\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\RegisterController;


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
require __DIR__ . '/restaurant/restaurantapi.php';
require __DIR__ . '/order/orderapi.php';
require __DIR__ . '/Customer/customerapi.php';
require __DIR__ . '/hibacustomerRoutes/customer.php';

require __DIR__ . '/Admin/admin.php';
require __DIR__ . '/Menu/Menu.php';

Route::post('/register', [RegisterController::class, 'signup']);
Route::post('/register-business', [RegisterController::class, 'registerRestaurantWithOwner']);

Route::controller(CartController::class)->group(function () {
    Route::get('/session', 'getShoppingSession');
});

    //Route::post('/reset-password', 'submitResetPasswordForm')->name('password.update');

Route::controller(UserController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});


Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post('/forgot-password', 'submitForgotPasswordForm')->name('password.email');
    Route::post('/reset-password', 'submitResetPasswordForm')->name('password.update');
});

Route::post('submit-restaurant-request', [RegisterController::class, 'submitRestaurantRequest']);



