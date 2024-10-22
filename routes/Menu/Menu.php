<?php

use App\GlobalVariables\PermissionVariables;
use App\Http\Controllers\Menu\MenuController;
use Illuminate\Support\Facades\Route;


    Route::prefix('menu')->controller(MenuController::class)->group(function () {
        Route::post(PermissionVariables::$createMenu['path'], 'createMenu');
        Route::post(PermissionVariables::$addMenuItems['path'], 'addMenuItem');
        Route::post(PermissionVariables::$addAddOns['path'], 'addOns');
        Route::post(PermissionVariables::$updateMenu['path'], 'updateMenu');
        Route::post(PermissionVariables::$updateMenuItem['path'], 'updateMenuItem');
        Route::post(PermissionVariables::$addChoice['path'], 'storeChoices');
        Route::get(PermissionVariables::$menuWithItemCount['path'], 'menuWithItemCount');
        Route::post(PermissionVariables::$updateChoice['path'], 'updateChoices');
        Route::get(PermissionVariables::$menuWithMenuItem['path'], 'getMenuwithMenuItem');
        Route::get(PermissionVariables::$getChoicesWithMenuItem['path'], 'getChoicesWithMenuItem');
        Route::delete(PermissionVariables::$deleteMenuItem['path'], [MenuController::class, 'deleteMenuItem']);

    });



Route::post('create-menu/{branch_id}', [MenuController::class, 'createMenu']);
Route::post('add-item/menu/{menu_id}', [MenuController::class, 'addMenuItem']);
Route::post('add-addon/menu/{menu_item_id}', [MenuController::class, 'addOns']);
Route::post('update-menu/{menu_item}', [MenuController::class, 'updateMenu']);
Route::post('update-menu-item/{menu_item_id}', [MenuController::class, 'updateMenuItem']);
Route::post('add-choice/{menu_id}', [MenuController::class, 'storeChoices']);
Route::delete('delete-item/{menu_item_id}', [MenuController::class, 'deleteMenuItem']);

