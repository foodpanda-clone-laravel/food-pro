<?php
namespace App\routes\Admin;

use App\GlobalVariables\PermissionVariables;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Permission;
Route::middleware(['jwt', 'routes.permissions'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('get-applications', 'viewRestaurantApplications');
        Route::post('accept-application/{request_id}', 'approveRequest');
        Route::post('reject-application/{request_id}', 'rejectRequest');
        Route::post('update-application/{request_id}', 'updateRestaurantApplication');
        Route::get('get-all-orders', 'viewAllOrders');
        Route::get('order-details/{order_id}', 'viewOrderDetails');

        Route::get(PermissionVariables::$viewDeactivatedRestaurants['path'], 'viewDeactivatedRestaurants');

        Route::get('show-deactivated-restaurants', 'viewDeactivatedRestaurants');
        Route::post('deactive-restaurant/{restaurant_id}', 'deactivateRestaurant');
        Route::post('activate-restaurant/{restaurant_id}', 'activateRestaurant');

        Route::get('show-restaurants', 'showRestaurants');
    });

});
