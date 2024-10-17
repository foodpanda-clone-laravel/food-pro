<?php
use \App\Http\Controllers\Menu\MenuControllerV2;
use App\Http\Controllers\Restaurant\RestaurantController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Restaurant\RevenueController;
Route::group(['middleware' => 'request.logs',], function () {
    Route::controller(MenuControllerV2::class)->group(function(){
        Route::get('view-menu-item','viewMenuItemById');
    });

});
