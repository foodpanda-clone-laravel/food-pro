<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequests\RegisterUserRequest;
use App\Http\Requests\AuthRequests\RegisterRestaurantWithOwnerRequest;
use App\Services\Auth\RegisterService;
use App\Helpers\Helpers;
use App\Http\Requests\AuthRequests\RestaurantSubmissionRequest;
use Symfony\Component\HttpFoundation\Response;

use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as HttpRequest;
use PHPUnit\TextUI\Help;

class RegisterController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService= $registerService;
    }


    public function signup(RegisterUserRequest $request){
        $result = $this->registerService->register($request);
        if($result){
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'User signed up successfully');
        }
        else{
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'could not signup');
        }
    }


    public function submitRestaurantRequest(RestaurantSubmissionRequest $request){
        $result = $this->registerService->submitRestaurantRequest($request->all());

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Request submitted successfully', $result);

 }

}
