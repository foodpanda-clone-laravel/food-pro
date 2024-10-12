<?php

namespace App\Services\Cart;

use App\Interfaces\ShoppingSessionServiceInterface;
use App\Models\ShoppingSession;
use Illuminate\Support\Facades\Auth;

class ShoppingSessionService implements ShoppingSessionServiceInterface
{
    public function __construct(){
    }

    public static function getShoppingSession(){
        $user = Auth::user();
        $shoppingSession =$user->shoppingSession;
        if(!$shoppingSession){
            ShoppingSession::create(['user_id'=>$user->id]);
            return [];
        }
        else{
            return  $shoppingSession->cartItems ?? [];

        }

    }
}
