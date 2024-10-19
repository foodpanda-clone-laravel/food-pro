<?php

namespace App\Services\Cart;

use App\DTO\Cart\CartItemDTO;
use App\Interfaces\Cart\CartServiceInterface;
use App\Models\Cart\CartItem;
use App\Models\Menu\MenuItem;
use App\Models\Menu\Variation;

class CartService extends ShoppingSessionService implements CartServiceInterface
{
    protected $shoppingSession;
    public function __construct(){
        $this->shoppingSession = ShoppingSessionService::getShoppingSession();
    }

    protected function calculateVariationTotal($cartItem){
        $variations = json_decode($cartItem['selected_variations'], true);
        $total =0;
        foreach($variations as $variation){
            $dbVariation  = Variation::where('id', $variation['id'])->first();
            $choiceItems = json_decode($dbVariation['choice_items'], true);
            $total +=$choiceItems[$variation['choice']];
        }
        return $total;
    }

    public function addToCart($data){
        try{

            $data['session_id']= $this->shoppingSession->id;
            $cartItemDTO = new CartItemDTO($data);
            $cartItem = CartItem::create($cartItemDTO->toArray());
            $total = $this->calculateVariationTotal($cartItem);

            $cartItem['total'] = $total;
            $menuItem = MenuItem::where('id',$cartItem['menu_item_id'])->first();
            $itemTotal = $cartItem['quantity']*$menuItem->price +$total;

            return $cartItem;
        }
        catch(\Exception $e){
            dd($e);
            return false;
        }
    }
    public function updateCartItem($data){

    }
    public function viewCart(){ // function not needed
        $cartItems = ShoppingSessionService::getShoppingSession();
        return Helpers::sendSuccessResponse(200,'cart items',$cartItems);
    }

}
