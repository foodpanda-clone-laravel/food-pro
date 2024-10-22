<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Http\Requests\SetPasswordRequest;
use App\Services\Auth\UserService;
use Illuminate\Http\JsonResponse;use Symfony\Component\HttpFoundation\Response;


class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        $result = $this->userService->loginUser($request);
        if (!$result) {

            return Helpers::sendFailureResponse(Response::HTTP_UNAUTHORIZED, 'Invalid Credentials');
        }
        else{
            return Helpers::sendSuccessResponse(
                Response::HTTP_OK,
                'Logged in successfully',
                $result,
                ['Authorization' => 'Bearer ' . $result['access_token']]
            );
        }

    }
    public function logout(): JsonResponse
    {
        $result = $this->userService->logoutUser();

        return Helpers::sendSuccessResponse(Response::HTTP_OK,'logged out successfully');
    }
    public function setPasswordAtFirstLogin(SetPasswordRequest $request){
        $result = $this->userService->setPasswordAtFirstLogin($request);
        return Helpers::sendSuccessResponse(Response::HTTP_OK,'set password successfully');


    }
}
