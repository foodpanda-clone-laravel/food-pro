<?php

namespace App\Services\Customer;

use App\DTO\Order\OrderDTO;
use App\DTO\Order\OrderItemDTO;
use App\DTO\Order\PaymentDTO;
use App\Interfaces\CustomerOrderServiceInterface;
use App\Models\Cart\CartItem;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Orders\Payment;
use App\Models\Restaurant\Branch;
use App\Services\Cart\CartService;
use App\Services\Cart\ShoppingSessionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerOrderService extends CustomerService implements CustomerOrderServiceInterface
{
    protected $cartService;
    protected $customer;
    protected $order;
    protected $shoppingSessionService;
    public function __construct(CartService $cartService, ShoppingSessionService $shoppingSessionService){
        $this->user = Auth::user();
        $this->customer = $this->user->customer;
        $this->cartService = $cartService;
        $this->shoppingSessionService = $shoppingSessionService;
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


    protected function createOrderItems($orderItems, $order){
        $orderedItems = [];

        foreach($orderItems as $orderItem){
            $orderItem['id']=$order->id;
            $orderItemDTO = new OrderItemDTO($orderItem);
            $orderItem = OrderItem::create($orderItemDTO->toArray());
            $orderedItems[] = $orderItem;
        }
        return $orderedItems;
    }
    protected function createPaymentForOrder($order){
        $paymentDTO = new  PaymentDTO($order->toArray());
        $payment = Payment::create($paymentDTO->toArray());
    }

    public function createOrder($address){
        try{
            DB::beginTransaction();
            $orderSummary = $this->checkout();
            $orderDTO = new OrderDTO((object)$orderSummary, $address);
            $order = Order::create($orderDTO->toArray());
            $orderItems = $orderSummary['items_total'];
            $orderItems = json_decode(json_encode($orderItems),true);
            $orderedItems = $this->createOrderItems($orderItems, $order);
            $this->createPaymentForOrder($order);
            $this->shoppingSessionService::deleteShoppingSession();
        Db::commit();
        return $orderedItems;
        }
        catch(\Exception $e){
            DB::rollBack();
            return false;
        }

    }
}
