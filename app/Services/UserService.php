<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Spatie\Permission\Models\Role;

class UserService
{
    public function createUser(array $data)
    {
        /**
         * instead of creating user like this change the data array
         * 
         */
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->assignRole('Customer');
       
        $role = Role::findByName('Customer');

        $permissions = $role->permissions->toArray();
        $permissionIds = array_column($permissions, 'id');
        $user->givePermissionTo($permissionIds);
       
        return $user;
    }


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

        $result = ['role' => $roleName, 'permissions' => $permissions, 'access_token' => $token, 'user_id' => $user_id];
        return $result; 
    }
}
