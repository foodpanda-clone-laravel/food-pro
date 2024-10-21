<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Services\Auth\UserService;
use Illuminate\Http\JsonResponse;

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

            return Helpers::sendFailureResponse(401, 'Invalid Credentials');
        }
        else{
            return Helpers::sendSuccessResponse(
                200,
                'Logged in successfully',
                $result,
                ['Authorization' => 'Bearer ' . $result['access_token']]
            );
        }

    }
    public function logout(): JsonResponse
    {
        $result = $this->userService->logoutUser();

        return Helpers::sendSuccessResponse(200,'logged out successfully');
    }
}
