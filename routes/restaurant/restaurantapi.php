<?php

use App\GlobalVariables\PermissionVariables;
use App\Http\Controllers\Restaurant\RestaurantController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Menu\MenuControllerV2;
use \App\Http\Controllers\Restaurant\RevenueController;
Route::group(['middleware' => 'request.logs',], function () {
    Route::controller(MenuControllerV2::class)->group(function () {
        Route::get(PermissionVariables::$menuChoiceGroup['path'], 'getChoiceGroupById');
        Route::post(PermissionVariables::$menuAssignChoiceGroup['path'], 'assignChoiceGroup');
        Route::get(PermissionVariables::$viewChoiceGroup['path'], 'getAllChoiceGroups');
        Route::post('/create-choice-group', 'createChoiceGroup');
        Route::delete(PermissionVariables::$deleteChoiceGroup['path'], 'deleteChoiceGroup');
        Route::post(PermissionVariables::$updateChoiceGroup['path'], 'updateChoiceGroup');

    });

});

    Route::controller(RestaurantController::class)->group(function(){
    // restaurant owner can only view their reviews
       Route::get(PermissionVariables::$reviews['path'], action: 'viewMyRatings');
    });
    Route::controller(RevenueController::class)->group(function(){
        Route::get(PermissionVariables::$revenue['path'], 'viewMyRevenue');
        Route::get(PermissionVariables::$restaurantRevenue['path'], 'viewRestaurantRevenues');
    });


Route::group(['middleware' => 'api',], function () {
    Route::get(PermissionVariables::$viewRestaurant['path'], [RestaurantController::class, 'viewRestaurantById']);
    Route::delete(PermissionVariables::$deactivateRestaurant['path'], [RestaurantController::class, 'deleteRestaurant']);
    Route::post(PermissionVariables::$updateRestaurant['path'], [RestaurantController::class, 'updateRestaurant']);
    Route::post(PermissionVariables::$restoreRestaurant['path'], [RestaurantController::class, 'restoreRestaurant']);

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
