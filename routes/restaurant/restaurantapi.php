<?php
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Menu\MenuControllerV2;
Route::group(['middleware' => 'api',], function () {
    Route::controller(MenuControllerV2::class)->group(function () {
       Route::post('menu/choice-group', 'addChoiceGroup');
        Route::post('menu/choice-group/choice-item', 'addChoiceItem');
        Route::get('menu/choice-group', 'getChoiceGroupById');
        Route::post('menu/assign-choice-group', 'assignChoiceGroup');
        Route::get('choice-groups','getAllChoiceGroups');


    });
});


/***
 * an example code to follow
 *  https://laraveldaily.com/post/laravel-routes-split-into-separate-files
 */
