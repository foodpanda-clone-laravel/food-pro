<?php

namespace App\Services\Auth;

use App\Mail\TwoFactorAuthMail;
use App\Services\Cart\ShoppingSessionService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PragmaRX\Google2FAQRCode\Google2FA;
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
    public function loginWith2FA( $credentials, $code = null)
    {
        try {
            // Attempt login with credentials
            if (!Auth::attempt($credentials)) {
                return ['error' => 'Invalid credentials'];
            }
            $user = Auth::user();
            $roleName = $user->roles->pluck('name')->first();
            // If first-time login and no 2FA setup, generate QR code
            if (in_array($roleName, ['Admin', 'Restaurant Owner']) && !$user->google2fa_secret) {
                return $this->setup2FA($user);
            }
            // If 2FA is required but not yet verified, validate the code
            if (!$user->is_2fa_verified) {
                if (!$code) {
                    return ['error' => '2FA code required.'];
                }
                if (!$this->verify2FACode($user, $code)) {
                    return ['error' => 'Invalid 2FA code.'];
                }
                // Mark the user as 2FA verified
                $user->is_2fa_verified = true;
                $user->save();
            }
            // Generate JWT token and response data
            return $this->generateLoginResponse($user, $roleName);
        } catch (Exception $e) {
            return ['error' => 'An error occurred during login.', 'message' => $e->getMessage()];
        }
    }
    private function setup2FA($user)
    {
        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey();
        // Store the secret key in the user's record
        $user->update(['google2fa_secret' => $secretKey]);
        $inlineUrl = $google2fa->getQRCodeInline('Food-pro', $user->email, $secretKey);
        Mail::to($user->email)->send(new TwoFactorAuthMail($secretKey, $inlineUrl));
        return [
            'firstLogin' => true,
            'message' => 'QR code sent to your email for 2FA setup.',
            'inlineUrl' => $inlineUrl,
            'secretKey' => $secretKey,
        ];
    }
    private function verify2FACode($user, $code)
    {
        $google2fa = new Google2FA();
        return $google2fa->verifyKey($user->google2fa_secret, $code);
    }
    private function generateLoginResponse($user, $roleName)
    {
        $token = JWTAuth::fromUser($user);
        $permissions = $user->getPermissionNames()->toArray();
        $result = [
            'role' => $roleName,
            'permissions' => $permissions,
            'access_token' => $token,
            'user_id' => $user->id,
        ];
        if ($roleName == 'Restaurant Owner') {
            $this->addRestaurantDetails($user, $result);
        } elseif ($roleName == 'Customer') {
            $result['cart_items'] = ShoppingSessionService::getShoppingSession()->cartItems;
        }
        return $result;
    }
    private function addRestaurantDetails($user, &$result)
    {
        $restaurant = $user->restaurantOwner->restaurant ?? null;
        $result['restaurant_details'] = $restaurant;
        if ($restaurant) {
            $address = $restaurant->branches->first();
            $result['restaurant_details']['address'] = $address
                ? "{$address->address} {$address->city} {$address->postal_code}"
                : null;
        }
    }


}
