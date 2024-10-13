<?php

namespace App\Http\Controllers\Orders;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Cart\CartService;
use App\Http\Requests\CartRequests\AddToCartRequest;
use App\Http\Requests\CartRequests\UpdateCartRequest;
use App\Models\ShoppingSession;
use App\Helpers\Helpers;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService){
        $this->cartService= $cartService;
    }
    public function addToCart(AddToCartRequest $request){
        $result = $this->cartService->addToCart($request->getValidatedData());
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

    // store the shopping cart session in session
    public function getShoppingSession(){
        $user= Auth::user();
        // logic for mainting shopping sessions
        // default query for shoppping session is get shopping session data for time - 24 hours
        $shoppingSession = ShoppingSession::query()
                                            ->where('created_at','>',now()->addHours(24))
                                            ->where('user_id', $user->id)->first();
        return response($shoppingSession);

    }
}
