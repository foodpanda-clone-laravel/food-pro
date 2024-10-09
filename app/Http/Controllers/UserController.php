<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        if ($this->userService->userExists($request->email)) {
            throw new HttpResponseException(response()->json([
                'message' => 'This email is already registered. Please log in or use another email.'
            ], 409));
        }

        $user = $this->userService->createUser($request->validated());

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        $token = $this->userService->loginUser($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Log the user to check if it's being retrieved correctly

        if (!$user) {
            return response()->json(['error' => 'Unable to fetch user.'], 500);
        }

        // Check if the user has a role and handle null role case
        $role = $user->role;
        $permissions = $role ? $role->permissions : [];

        // Return the response payload
        return response()->json([
            'user_id' => $user->id,
            'role' => $role, // Returns role if exists, null otherwise
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'permissions' => $permissions, // Returns permissions or empty array
        ]);
    }
}
