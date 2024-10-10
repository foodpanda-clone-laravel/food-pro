<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Cart\CartService;
use App\Http\Requests\CartRequests\AddToCartRequest;
use App\Http\Requests\CartRequests\UpdateCartRequest;


class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService){
        $this->cartService= $cartService;
    }
    public function addToCart(AddToCartRequest $request){
        $this->cartService->addToCart($request->getValidatedData());
    }
    public function updateCartItem(){

    }
    public function viewCart(){

    }

}
