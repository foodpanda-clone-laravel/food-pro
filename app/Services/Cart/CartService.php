<?php

namespace App\Services\Cart;

use App\Interfaces\Cart\CartServiceInterface;
use App\Models\Cart;
use App\Models\ShoppingSession;
use Illuminate\Support\Facades\Session;
class CartService implements CartServiceInterface
{
    public function addToCart($data){

    }
    public function updateCartItem($data){

    }
    public function viewCart($data){
        
    }
    public function getCart($shoppingSession){
        
        $userCart = Cart::where('session_id', $shoppingSession->id)->first();
        return $userCart;
    }
}
