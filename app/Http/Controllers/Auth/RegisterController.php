<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequests\RegisterUserRequest;
use App\Http\Requests\AuthRequests\RegisterRestaurantWithOwnerRequest;
use App\Services\Auth\RegisterService;
use App\Helpers\Helpers;
class RegisterController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService= $registerService;
    }

    public function registerRestaurantWithOwner(RegisterRestaurantWithOwnerRequest $request)
    {
        // resolve validation error for
        $data  = $request->getValidatedData();
        $result = $this->registerService->createRestaurantWithOwner($data);
        if($result){
            return Helpers::sendSuccessResponse(201, 'Restaurant and owner registered successfully', $result);
        }
        else{
            return false;
        }

    }
    public function signup(RegisterUserRequest $request){
        $data  = $request->getValidatedData();
        $result = $this->registerService->register($data);
        if($result){
            return Helpers::sendSuccessResponse(200, 'User signed up successfully');
        }
        else{
            return Helpers::sendFailureResponse(400, 'could not signup');
        }
    }

}
