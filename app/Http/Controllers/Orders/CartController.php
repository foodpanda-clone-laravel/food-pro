<?php

namespace App\Http\Controllers\Orders;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequests\AddToCartRequest;

use App\Services\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;


class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService){
        $this->cartService= $cartService;
    }
    public function addToCart(AddToCartRequest $request){
        $result = $this->cartService->addToCart($request->all());
        if(!$result){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'internal server error', $result);
        }
        else{
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Added to cart successfully', $result);

        }
    }


    public function calculateItemsTotal(AddToCartRequest $request){

        $cart = $this->addToCart($request);
        $total = $this->cartService->calculateItemsTotal();
        return response($total, Response::HTTP_OK);
    }
    public function calculateCartTotal(){
        $total = $this->cartService->calculateCartTotal();
        return response($total, Response::HTTP_OK);
    }
}
