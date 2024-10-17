<?php

use App\Http\Controllers\Menu\MenuController;
use Illuminate\Support\Facades\Route;

  


Route::post('create-menu/{branch_id}', [MenuController::class, 'createMenu']);
Route::post('add-item/menu/{menu_id}', [MenuController::class, 'addMenuItem']);
Route::post('add-addon/menu/{menu_item_id}', [MenuController::class, 'addOns']);
Route::post('update-menu/{menu_item}', [MenuController::class, 'updateMenu']);
Route::post('update-menu-item/{menu_item_id}', [MenuController::class, 'updateMenuItem']);
Route::post('add-choice/{menu_id}', [MenuController::class, 'storeChoices']);
Route::delete('delete-item/{menu_item_id}', [MenuController::class, 'deleteMenuItem']);