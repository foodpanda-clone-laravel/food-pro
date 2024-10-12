<?php

namespace App\Services;

use App\Services\Cart\ShoppingSessionService;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;
use Tymon\JWTAuth\Facades\JWTAuth;
class UserService extends ShoppingSessionService
{
    public function loginUser(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);


        // ask sir raheel what is the better approach to get role of a user
        //$role = $user->role->roleName->name;
        // should we use jwt custom claims to store roles and permissions

        $user_id = $user->id;
        $roleName = $user->roles->pluck('name')[0];


        $user_id = $user->id;
        $roleName= $user->roles->pluck('name')[0]; // this approach gives error if there are no roles assigned to the user?/
        $permissions = $user->permissions->toArray();
        $permissions = array_column($permissions, 'name');
        $cartItems = ShoppingSessionService::getShoppingSession();
        $result = ['role' => $roleName, 'permissions' => $permissions, 'access_token' => $token, 'user_id' => $user_id, 'cart_items' => $cartItems];
        if($roleName == 'Restaurant Owner'){
            $data['restaurant_id'] = $user->restaurnat;
        }


        $result = ['role' => $roleName, 'permissions' => $permissions, 'access_token' => $token, 'user_id' => $user_id];


        return $result;
    }

    public function logoutUser()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
