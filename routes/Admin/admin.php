<?php
namespace App\routes\Admin;

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;





Route::controller(AdminController::class)->group(function () {
    Route::get('get-applications', 'viewRestaurantApplications');
    Route::post('accept-application/{request_id}', 'approveRequest');
    
 });  
