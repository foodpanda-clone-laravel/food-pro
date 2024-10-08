<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        // Check if the user already exists
        if ($this->userService->userExists($request->email)) {
            throw new HttpResponseException(response()->json([
                'message' => 'This email is already registered. Please log in or use another email.'
            ], 409)); // 409 Conflict
        }

        // Create the user if they do not exist
        $user = $this->userService->createUser($request->validated());

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }
}
