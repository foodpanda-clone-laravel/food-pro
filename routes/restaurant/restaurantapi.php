<?php

use App\GlobalVariables\PermissionVariables;
use App\Http\Controllers\Menu\ChoiceGroupController;
use App\Http\Controllers\Rating\RatingsController;
use App\Http\Controllers\Restaurant\RestaurantController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Restaurant\RevenueController;
Route::group(['middleware' => 'request.logs',], function () {
    Route::controller(ChoiceGroupController::class)->group(function () {
        Route::get(PermissionVariables::$menuChoiceGroup['path'], 'getChoiceGroupById');
        Route::post(PermissionVariables::$menuAssignChoiceGroup['path'], 'assignChoiceGroup');
        Route::get(PermissionVariables::$viewChoiceGroup['path'], 'getAllChoiceGroups');
        Route::post('/create-choice-group', 'createChoiceGroup');
        Route::delete(PermissionVariables::$deleteChoiceGroup['path'], 'deleteChoiceGroup');
        Route::post(PermissionVariables::$updateChoiceGroup['path'], 'updateChoiceGroup');

    });

    Route::controller(RatingsController::class)->group(function(){
        // restaurant owner can only view their reviews
        Route::get(PermissionVariables::$reviews['path'], action: 'viewMyRestaurantRating');
        Route::get('/restaurant-reviews', 'viewRestaurantReviews');
    });
    Route::controller(RevenueController::class)->group(function(){
        Route::get(PermissionVariables::$revenue['path'], 'viewMyRevenue');
        Route::get(PermissionVariables::$restaurantRevenue['path'], 'viewRestaurantRevenues');
    });


Route::group(['middleware' => 'api',], function () {
    Route::get(PermissionVariables::$viewRestaurant['path'], [RestaurantController::class, 'viewRestaurantById']);
    Route::delete(PermissionVariables::$deactivateRestaurant['path'], [RestaurantController::class, 'deleteRestaurant']);
    //Route::post(PermissionVariables::$updateRestaurant['path'], [RestaurantController::class, 'updateRestaurant']);
    Route::post(PermissionVariables::$restoreRestaurant['path'], [RestaurantController::class, 'restoreRestaurant']);
    Route::get(PermissionVariables::$showRestaurantDetails['path'], [RestaurantController::class, 'showRestaurantDeatils']);
    Route::post(PermissionVariables::$updateRestaurantDetails['path'], [RestaurantController::class, 'updateRestaurant']);


});
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
