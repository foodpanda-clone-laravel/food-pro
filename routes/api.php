<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\APIRequestLogsMiddleware;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\QueryException;
use App\Models\ApiRequestLog;
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

Route::post('register', [UserController::class, 'register']);
Route::post('/restaurant/register-with-owner', [RestaurantController::class, 'registerRestaurantWithOwner']);
Route::post('/login', [UserController::class, 'login']);


Route::middleware(['jwt'])->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->auth);
        
    });
});
Route::middleware('request.logs')->group(function(){
    Route::controller(ForgotPasswordController::class)->group(function(){
        Route::post('/forgot-password', 'submitForgotPasswordForm');
    });     
});
Route::get('/hello', function(){
    return "hello";
});