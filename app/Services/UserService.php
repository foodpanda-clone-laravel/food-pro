<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    public function createUser(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function userExists(string $email): bool
    {
        return User::where('email', $email)->exists();
    }

    public function loginUser(array $credentials)
    {
        if (Auth::attempt($credentials)) {
            // Get the authenticated user
            $user = Auth::user();
            // Generate JWT token
            return JWTAuth::fromUser($user);
        }

        return false; // Return false if authentication fails
    }
}
