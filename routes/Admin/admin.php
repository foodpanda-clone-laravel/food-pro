<?php
namespace App\routes\Admin;

use App\GlobalVariables\PermissionVariables;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;

Route::controller(AdminController::class)->group(function () {
    Route::get(PermissionVariables::$viewRestaurantApplications['path'], 'viewRestaurantApplications');
    Route::post(PermissionVariables::$acceptApplication['path'], 'approveRequest');
    Route::post(PermissionVariables::$rejectApplication['path'], 'rejectRequest');
    Route::post(PermissionVariables::$updateApplication['path'], 'updateRestaurantApplication');
    Route::get(PermissionVariables::$viewAllOrders['path'], 'viewAllOrders');
    Route::get(PermissionVariables::$viewOrderDetails['path'], 'viewOrderDetails');

    Route::get(PermissionVariables::$viewDeactivatedRestaurants['path'], 'viewDeactivatedRestaurants');

   // Route::get('show-deactivated-restaurants', 'viewDeactivatedRestaurants');
    Route::post(PermissionVariables::$AdmindeactivateRestaurant['path'], 'deactivateRestaurant');
    Route::post(PermissionVariables::$AdminactivateRestaurant['path'], 'activateRestaurant');
    
    Route::get('show-restaurants', 'showRestaurants');
 });  
