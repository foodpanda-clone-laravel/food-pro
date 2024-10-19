<?php

namespace App\Services\Cart;

use App\DTO\Cart\CartItemDTO;
use App\Interfaces\AddToCartServiceV2Interface;
use App\Models\Cart\CartItem;
use Illuminate\Support\Facades\DB;

class AddToCartServiceV2 implements AddToCartServiceV2Interface
{
    protected $shoppingSession;
    public function __construct(){
        $this->shoppingSession = ShoppingSessionService::getShoppingSession();
    }

    public function calculateItemsTotal(){
        // to calcualate total
        /***
         * to calculate total of a single product i need to
         * group by the menu item id
         * get the base price of the menu item id ,
         *  get the choice_id additional price
         * multiply the quantity with the menu_item id
         * and add the choice
         */;
        $eachItemsTotal = DB::table('cart_items as cart_items')
            ->select(
                'cart_items.menu_item_id',
                'menu_items.name AS menu_item_name',
                'cart_items.quantity',
                'menu_items.price',
                DB::raw('menu_items.price * cart_items.quantity + SUM(choices.additional_price * cart_items.quantity) AS total_price'),
                DB::raw('GROUP_CONCAT(choices.name) AS choice_names')
            )
            ->join('menu_items', 'cart_items.menu_item_id', '=', 'menu_items.id')
            ->leftJoin('choices', 'cart_items.choice_id', '=', 'choices.id') // Use LEFT JOIN in case cart_items have no choice
            ->where('cart_items.session_id', $this->shoppingSession->id)
            ->groupBy(
                'cart_items.menu_item_id',
                'cart_items.quantity',
                'menu_items.price',
                'menu_items.name'
            )
            ->get()->toJson();
        return $eachItemsTotal;
    }
    public function calculateCartTotal(){
// whenever cart is updated run this query to calculate cart total,
        // also the calculate items total function

            // Subquery to calculate the total price for each cart item
            $totalCartPrice = DB::table(DB::raw('(SELECT
                                           cart_items.menu_item_id,
                                           menu_items.name AS menu_item_name,
                                           cart_items.quantity,
                                           (menu_items.price * cart_items.quantity) + IFNULL(SUM(choices.additional_price * cart_items.quantity), 0) AS total_price,
                                           GROUP_CONCAT(choices.name) AS choice_names
                                    FROM cart_items
                                    INNER JOIN menu_items ON cart_items.menu_item_id = menu_items.id
                                    LEFT JOIN choices ON cart_items.choice_id = choices.id
                                    WHERE cart_items.session_id = '.$this->shoppingSession->id.'
                                    GROUP BY cart_items.menu_item_id, cart_items.quantity, menu_items.price, menu_items.name) AS subquery'))
                ->select(DB::raw('SUM(subquery.total_price) AS total_cart_price'))
                ->value('total_cart_price');

            return $totalCartPrice;

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

    public function viewCart($data){
        return $this->shoppingSession->cart;
    }
    public function updateCart($data){

    }
    public function deleteCart($data){

    }

}
