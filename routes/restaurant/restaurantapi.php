<?php
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Menu\MenuControllerV2;
use \App\Http\Controllers\Restaurant\RestaurantController;
Route::group(['middleware' => 'api',], function () {
    Route::controller(MenuControllerV2::class)->group(function () {
        Route::get('menu/choice-group', 'getChoiceGroupById');
        Route::post('menu/assign-choice-group', 'assignChoiceGroup');
        Route::get('choice-groups','getAllChoiceGroups');
        Route::post('/create-choice-group', 'createChoiceGroup');
    });

    Route::controller(RestaurantController::class)->group(function(){
    // restaurant owner can only view their reviews
       Route::get('/my-reviews', 'viewMyRatings');
       Route::get('/my-revenue', 'viewMyRevenueReport');
    });

});



/***
 * an example code to follow
 *  https://laraveldaily.com/post/laravel-routes-split-into-separate-files
 */
