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

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Restaurant applications', $result);

    }


    public function approveRequest($request_id){
        $result= $this->adminService->approveRequest($request_id);

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Your request has been approved', $result);

    }
    public function rejectRequest($request_id){
        $result= $this->adminService->rejectRequest($request_id);

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Your request has been rejected', $result);

    }

    public function viewAllRestaurants(){
        $result= $this->adminService->viewAllRestaurants();

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'All restaurants', $result);

    }

    public function updateRestaurantApplication(UpdateApplicationRequest $request,$request_id){
        $result= $this->adminService->updateRestaurantApplication($request->all(),$request_id);

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Your request has been updated', $result);
}
    public function viewAllOrders(){
        $result= $this->adminService->viewAllOrders();

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'All orders', $result);


}
    public function viewOrderDetails($order_id){
        $result= $this->adminService->viewOrderDetails($order_id);

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'All orders', $result);

    }
    public function viewDeactivatedRestaurants(){
        $result= $this->adminService->viewDeactivatedRestaurants();

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'Deactivated restaurants', $result);

    }

}
