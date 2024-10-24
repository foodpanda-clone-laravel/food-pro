<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateApplicationRequest;
use App\Services\Admin\AdminService;
use Symfony\Component\HttpFoundation\Response;


class AdminController extends Controller
{

    protected $adminService;
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;


    }



    public function viewRestaurantApplications(){

        $result= $this->adminService->viewRestaurantApplications();

        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);

    }


    public function approveRequest($request_id){
        $result= $this->adminService->approveRequest($request_id);

        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);

    }
    public function rejectRequest($request_id){
        $result= $this->adminService->rejectRequest($request_id);

        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);

    }

    public function viewAllRestaurants(){
        $result= $this->adminService->viewAllRestaurants();

        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);

    }

    public function updateRestaurantApplication(UpdateApplicationRequest $request,$request_id){
        $result= $this->adminService->updateRestaurantApplication($request->all(),$request_id);

        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);
}
    public function viewAllOrders(){
        $result= $this->adminService->viewAllOrders();

        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);


}
    public function viewOrderDetails($order_id){
        $result= $this->adminService->viewOrderDetails($order_id);

        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);

    }
    public function viewDeactivatedRestaurants(){
        $result= $this->adminService->viewDeactivatedRestaurants();

        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);

    }

    public function deactivateRestaurant($restaurant_id){
        $result= $this->adminService->deactivateRestaurant($restaurant_id);
        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);
    }
    public function activateRestaurant($restaurant_id){
        $result= $this->adminService->activateRestaurant($restaurant_id);
        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);
    }
    public function showRestaurants(){
        $result= $this->adminService->showRestaurants();
        return Helpers::sendSuccessResponse($result['header_code'],$result['message'], $result['body']);
    }

}
