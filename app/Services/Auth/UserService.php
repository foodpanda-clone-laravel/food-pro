<?php

namespace App\Services\Auth;

use App\Services\Cart\ShoppingSessionService;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService extends ShoppingSessionService
{
    public function loginUser($credentials)
    {
        try{
            if (!Auth::attempt($credentials->toArray())) {
                return false;
            }
            $user = Auth::user();
            $token = JWTAuth::fromUser($user);
            $roleName= $user->roles->pluck('name')[0];
            // should we use jwt custom claims to store roles and permissions
            $user_id = $user->id;
            $permissions = $user->getPermissionNames()->toArray();
            $result = ['role' => $roleName, 'permissions' => $permissions, 'access_token' => $token, 'user_id' => $user_id];
            if ($roleName == 'Restaurant Owner') {
                // Get restaurant details or assign null if restaurantOwner or restaurant is missing
                $restaurant = $user->restaurantOwner->restaurant ?? null;
                $result['restaurant_details'] = $restaurant;

                if ($restaurant) {
                    // If branches exist, retrieve the first address details
                    $address = $restaurant->branches->first() ?? null;

                    // Assign address details if available, otherwise null
                    $addressDetails = $address
                        ? $address->address . ' ' . $address->city . ' ' . $address->postal_code
                        : null;

                    // Include the address in restaurant details
                    $result['restaurant_details']['address'] = $addressDetails;
                }
            }

            else if ($roleName == 'Customer'){
                    $shoppingSession = ShoppingSessionService::getShoppingSession();
                    $cartItems = $shoppingSession->cartItems;
                    $result['cart_items'] = $cartItems;
            }
            return $result;

        }


        catch (\Exception $e){
            dd($e);
//dd($e->getMessage());
            return false;
        }
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
