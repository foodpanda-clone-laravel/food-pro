<?php

namespace App\Services\Cart;

use App\DTO\Cart\CartItemDTO;
use App\Interfaces\CartServiceInterface;
use App\Models\Cart\CartItem;
use Illuminate\Support\Facades\DB;

class CartService implements CartServiceInterface
{
    protected $shoppingSession;
    public function __construct(){
        $this->shoppingSession = ShoppingSessionService::getShoppingSession();
    }

        /***
         * to calculate total of a single product i need to
         * group by the menu item id
         * get the base price of the menu item id ,
         *  get the choice_id additional price
         * multiply the quantity with the menu_item id
         * and add the choice
         */
    public function calculateItemsTotal(){

        $eachItemsTotal = CartItem::with(['menuItem', 'choice'])
            ->select(
                'menu_item_id',
                'quantity',
                'choice_group_id',
                'choice_id'
            )
            ->where('session_id', $this->shoppingSession->id)
            ->get()
            ->map(function ($cartItem) {
                // Calculate total_price and choice_names for each cart item
                $menuItem = $cartItem->menuItem;
                $choice = $cartItem->choice??null;
                $totalPrice = $menuItem->price * $cartItem->quantity;

                if ($choice) {
                    $totalPrice += $choice->price * $cartItem->quantity; // Add choice price to total
                    $choiceNames = $choice->name;
                } else {
                    $choiceNames = null;
                }

                return [
                    'menu_item_id' => $cartItem->menu_item_id,
                    'menu_item_name' => $menuItem->name,
                    'quantity' => $cartItem->quantity,
                    'price' => $menuItem->price,
                    'total_price' => $totalPrice,
                    'choice_names' => $choiceNames,
                ];
            });
        return $eachItemsTotal;
    }

    public function addToCart($data){
        // we store the data in database in a format that is easy for us to handle, edit and update.
        // we use ids because when we edit or update one entity in our database the other tables will also get updated
        // the reason why we are not choosing json columns and keys is that let's suppose a user adds an item to the cart and doesn't checkout.
        // after some time the item variation price changed, so the changed price will not reflect the cart items price because it was changed after
        // the item was added to the cart. in other case if we add choice group id or choice id in the cart it's price will get updated in realtime.
//          cart_choices
//        id |  choice_group_id|choice_id
//        1  |             1   |        | 1
//        2  |            2    |      | 1


        // Assuming session_id is available from request or session
        $sessionId = ShoppingSessionService::getShoppingSession();

        /***
         * cases:
         *  CASE 1 : if there is a variation , use loop to convert the variation to dto and
         *  CASE 2 : if there is no variation use dto to insert the cart item
         *
         */
        // Decode variations JSON

        $data['session_id'] = $sessionId->id;

        if(!isset($data['variations'])){
            $cartItemDTO = new CartItemDTO($data);
            $cartItem = CartItem::create($cartItemDTO->toArray());
            return $cartItem;
        }
        else{
            $data['variations'] = json_decode($data['variations'], true);
            foreach ($data['variations'] as $variation) {
                $variationData = array_merge($data, $variation);
                $cartItemDTO = new CartItemDTO($variationData);
                $cartItem = CartItem::create($cartItemDTO->toArray());
            }
            return $cartItem;
        }
    }

}
