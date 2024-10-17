<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use Illuminate\Http\Request;
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

    
}
