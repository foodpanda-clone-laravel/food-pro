<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle user registration.
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        // Check if user already exists
        if ($this->userService->userExists($request->email)) {
            return Helpers::sendFailureResponse(400, 'User already exists');
        }

        // Create the user
        $user = $this->userService->createUser($request->validated());

        // Send success response
        return Helpers::sendSuccessResponse(201, 'User registered successfully', ['user' => $user]);
    }

    /**
     * Handle user login.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Validate credentials and attempt login
        $credentials = $request->validated();
        $result = $this->userService->loginUser($credentials);

        // If authentication fails, send failure response
        if (!$result) {
            return Helpers::sendFailureResponse(401, 'Unauthorized');
        }

        // If authentication succeeds, send success response with token
        return Helpers::sendSuccessResponse(
            200,
            'Logged in successfully',
            $result,
            ['Authorization' => 'Bearer ' . $result['access_token']]
        );
    }
}
