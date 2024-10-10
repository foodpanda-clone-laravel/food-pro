<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequests\RegisterUserRequest;
use App\Http\Requests\AuthRequests\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());

        return Helpers::sendSuccessResponse(201, 'User registered successfully', ['user' => $user]);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->getValidatedData();
        $result = $this->userService->loginUser($credentials);

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
}
