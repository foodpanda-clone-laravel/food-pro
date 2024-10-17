<?php

namespace App\Services\Orders;

use App\Models\Orders\Order;
use App\Models\Orders\Order as OrdersOrder;
use App\Models\Restaurant\Restaurant;
use App\Models\User\RestaurantOwner;
use Illuminate\Pipeline\Pipeline;
use App\Pipelines\Filters;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderService
{

    public function getRestaurantOwner()
    {
        $user = Auth::user();
        $owner = RestaurantOwner::where('user_id', $user->id)->firstOrFail();
        $restaurant = Restaurant::where('owner_id', $owner->id)->firstOrFail();

        return $restaurant;
    }
    public function getUserOrders()
    {
        $restaurant=$this->getRestaurantOwner();
        $query = Order::where('restaurant_id', $restaurant->id );
        return app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Pipelines\Filters\StatusFilter::class,
                \App\Pipelines\Filters\OrderTypeFilter::class,
            ])
            ->thenReturn()
            ->paginate(10);
    }

    public function confirmOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Update the order status to 'delivered'
        $order->status = 'delivered';
        $order->save();

        Log::info('Order confirmed', ['order_id' => $orderId]);

        return $order;
    }

    public function cancelOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Update the order status to 'canceled'
        $order->status = 'canceled';
        $order->save();

        Log::info('Order canceled', ['order_id' => $orderId]);

        return $order;
    }

    
}