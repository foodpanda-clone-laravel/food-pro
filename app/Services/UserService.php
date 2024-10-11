<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\Cart\ShoppingSessionService;
class UserService
{
    public function loginUser(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);
        $user_id = $user->id;
        $roleName= $user->roles->pluck('name')[0];


        $permissions = $user->permissions->toArray();
        $permissions = array_column($permissions, 'name');
        if($roleName == 'Restaurant Owner'){
            $data['restaurant_id'] = $user->restaurnat;
        }


        $result = ['role' => $roleName, 'permissions' => $permissions, 'access_token' => $token, 'user_id' => $user_id];


        return $result;
    }

}
