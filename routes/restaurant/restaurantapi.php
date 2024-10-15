<?php

use App\Http\Controllers\Restaurant\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'api',], function () {
    Route::get('/restaurant', [RestaurantController::class, 'viewRestaurantById']);
    Route::delete('/restaurant', [RestaurantController::class, 'deleteRestaurant']);
    Route::post('/restaurant/update', [RestaurantController::class, 'updateRestaurant']);
    Route::post('/restaurant/restore', [RestaurantController::class, 'restoreRestaurant']);
        
});


/***
 * an example code to follow
 *  https://laraveldaily.com/post/laravel-routes-split-into-separate-files
 */
// Route::middleware(['request.logs', 'jwt'])->group(function () {
// });
Route::get('/hello', function(){
    return 'hello';
});