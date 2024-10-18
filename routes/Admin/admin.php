<?php
namespace App\routes\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;





Route::controller(AdminController::class)->group(function () {
    Route::get('get-applications', 'viewRestaurantApplications');
    Route::post('accept-application/{request_id}', 'approveRequest');
    Route::post('reject-application/{request_id}', 'rejectRequest');
    Route::post('update-application/{request_id}', 'updateRestaurantApplication');
    Route::get('get-all-orders', 'viewAllOrders');
    Route::get('order-details/{order_id}', 'viewOrderDetails');

    Route::get('show-deactivated-restaurant', 'viewDeactivatedRestaurants');

    
 });  
