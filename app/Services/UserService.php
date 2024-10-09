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
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);        // Check if the user has a role and handle null role case
        $role = $user->roles;
        $user_id = $user->id;

        // Get the first role name if the user has any roles
        $role = $user->roles->first() ? $user->roles->first()->name : null;

        // Get permissions names if the user has roles
        $permissions = $user->roles->first() ? $user->roles->first()->permissions->pluck('name') : [];

        $result = ['role' => $role, 'permissions' => $permissions, 'access_token' => $token, 'user_id' => $user_id];
        return $result; // Return false if authentication fails
    }
}
