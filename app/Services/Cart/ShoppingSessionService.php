<?php

namespace App\Services\Cart;

use App\DTO\ShoppingSessionDTO;
use App\Interfaces\ShoppingSessionServiceInterface;
use App\Models\ShoppingSession;
use Illuminate\Support\Facades\Auth;

class ShoppingSessionService implements ShoppingSessionServiceInterface
{
    public function __construct(){

        $user = Auth::user();
        $shoppingSession =$user->shoppingSession;
    }

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
