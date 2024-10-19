<?php

namespace App\Services\Cart;

use App\DTO\Cart\ShoppingSessionDTO;
use App\Interfaces\ShoppingSessionServiceInterface;
use App\Models\Cart\ShoppingSession;
use Illuminate\Support\Facades\Auth;

class ShoppingSessionService implements ShoppingSessionServiceInterface
{

    public static function getShoppingSession(){
        $user = Auth::user();
        $shoppingSession =$user->shoppingSession;
        if(!$shoppingSession){
            $sessionDTO = new ShoppingSessionDTO(['user_id'=>$user->id]);
            $shoppingSession = ShoppingSession::create($sessionDTO->toArray());
        }
        return $shoppingSession;
    }

}
