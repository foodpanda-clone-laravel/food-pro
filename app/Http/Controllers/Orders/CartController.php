<?php

namespace App\Http\Controllers\Orders;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequests\AddToCartRequest;
use App\Http\Requests\CartRequests\AddToCartRequestV2;
use App\Services\Cart\AddToCartServiceV2;

use Symfony\Component\HttpFoundation\Response;


class CartController extends Controller
{
    protected $cartService;
    public function __construct(AddToCartServiceV2 $cartService){
        $this->cartService= $cartService;
    }
    public function addToCart(AddToCartRequestV2 $request){
        $result = $this->cartService->addToCart();
        if(!$result){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'internal server error', $result);
        }
        else{
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Added to cart successfully', $result);

        }
    }
    public function updateCartItem(){

    }
    public function viewCart(){

    }

    public function calculateItemsTotal(AddToCartRequestV2 $request){

        $cart = $this->addToCart();

        $total = $this->cartService->calculateItemsTotal();
        return response($total, Response::HTTP_OK);
    }
    public function calculateCartTotal(){
        $total = $this->cartService->calculateCartTotal();
        return response($total, Response::HTTP_OK);
    }
}
