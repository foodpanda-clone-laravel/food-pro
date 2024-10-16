<?php

use App\Http\Controllers\Menu\MenuController;
use Illuminate\Support\Facades\Route;


Route::prefix('menu')->controller(MenuController::class)->group(function () {
    Route::post('create/{branch_id}', 'createMenu');
    Route::post('add-item/{menu_id}', 'addMenuItem');
    Route::post('add-addon/{menu_item_id}', 'addOns');
    Route::post('update/{menu_item}', 'updateMenu');
    Route::post('update-item/{menu_item_id}', 'updateMenuItem');
    Route::post('add-choice/{menu_id}', 'storeChoices');
    Route::get('count', 'menuWithItemCount');
    Route::post('update-choice/{variation_id}', 'updateChoices');
    Route::get('with-item/{menu_id}', 'getMenuwithMenuItem');
    Route::get('choices/{menu_item_id}', 'getChoicesWithMenuItem');
});
