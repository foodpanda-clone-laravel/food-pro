<?php

namespace App\Services\Customer;

use App\DTO\Order\OrderDTO;
use App\DTO\Order\OrderItemDTO;
use App\Interfaces\CustomerOrderServiceInterface;
use App\Models\Cart\CartItem;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Restaurant\Branch;
use App\Services\Cart\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerOrderService extends CustomerService implements CustomerOrderServiceInterface
{
    protected $cartService;
    protected $customer;
    public function __construct(CartService $addToCartServiceV2){
        $user = Auth::user();
        $this->customer = $user->customer;
        $this->cartService = $addToCartServiceV2;
    }
    public function checkout()
    {
        $itemsTotal = $this->cartService->calculateItemsTotal();
        $total = $itemsTotal->sum('total_price');

        // get restaurant for the order

        $restaurant =  CartItem::with('restaurant')
            ->select('restaurant_id')
            ->groupBy('restaurant_id')
            ->first()
            ->restaurant;
        // as for now we have only one branch so we are searching for branch with given restaurant id
        $branch= $restaurant->branches->first();
        return [
            'total' => $total,
            'items_total' => $itemsTotal,
            'branch' => $branch,
            'restaurant' => $restaurant,
            'customer' => $this->customer
        ];
    }
    public function createOrder($address){
        try{
            DB::beginTransaction();
            $orderSummary = $this->checkout();
            $orderDTO = new OrderDTO((object)$orderSummary, $address);
            $order = Order::create($orderDTO->toArray());
            $orderItems = $orderSummary['items_total'];
            $orderItems = json_decode(json_encode($orderItems),true);
            $orderedItems = [];
        foreach($orderItems as $orderItem){
            $orderItem['id']=$order->id;
            $orderItemDTO = new OrderItemDTO($orderItem);
            $orderItem = OrderItem::create($orderItemDTO->toArray());
            $orderedItems[] = $orderItem;
        }
        // fix total price null

//            $paymentDTO = make payment table
        Db::commit();
        return $orderedItems;
        }
        catch(\Exception $e){
            DB::rollBack();
            dd($e);

            return false;
        }

    }
}
