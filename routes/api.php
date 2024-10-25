<?php

use App\GlobalVariables\PermissionVariables;
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
Route::middleware(['api'])->group(function () {

    require __DIR__ . '/restaurant/restaurantapi.php';
    require __DIR__ . '/order/orderapi.php';
    require __DIR__ . '/Customer/customerapi.php';
    require __DIR__ . '/hibacustomerRoutes/customer.php';

    require __DIR__ . '/Admin/admin.php';
    require __DIR__ . '/Menu/Menu.php';
});

Route::post(PermissionVariables::$register['path'],[RegisterController::class, 'signup']);
Route::post(PermissionVariables::$registerBusiness['path'], [RegisterController::class, 'registerRestaurantWithOwner']);

Route::controller(CartController::class)->group(function () {
    Route::get(PermissionVariables::$session['path'], 'getShoppingSession');
});

    //Route::post('/reset-password', 'submitResetPasswordForm')->name('password.update');

Route::middleware('api')->group(function () {
    Route::get('/example', function(){
        return 'example';
    });
});
Route::controller(UserController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('logout', 'logout');

    Route::post('loginV2', 'loginV2');
    Route::post('twofa', 'verify2FACode');
});


Route::controller(ForgotPasswordController::class)->group(function () {
    Route::post(PermissionVariables::$forgotPassword['path'], 'submitForgotPasswordForm')->name('password.email');
    Route::post(PermissionVariables::$resetPassword['path'], 'submitResetPasswordForm')->name('password.update');
});

Route::post(PermissionVariables::$submitRestaurantRequest['path'], [RegisterController::class, 'submitRestaurantRequest']);


