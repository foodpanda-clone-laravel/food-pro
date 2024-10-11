<?php

namespace App\Services\Cart;

use App\Interfaces\Cart\CartServiceInterface;
use App\Models\Cart;
use App\Models\ShoppingSession;
use Illuminate\Support\Facades\Session;
class CartService extends ShoppingSessionService implements CartServiceInterface
{
    private $shoppingSession;   // i want to get this shopping session variable from shoppingsessionservice
    public function addToCart($data){

    }
    public function updateCartItem($data){

    }
    public function viewCart(){ // function not needed
        $cartItems = ShoppingSessionService::getShoppingSession();
        return Helpers::sendSuccessResponse(200,'cart items',$cartItems);
    }
}
