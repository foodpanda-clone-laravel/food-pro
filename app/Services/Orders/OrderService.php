<?php

namespace App\Services\Orders;

use App\Models\Orders\Order;
use App\Models\Restaurant\Restaurant;
use App\Models\User\RestaurantOwner;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function getRestaurantOwner()
    {
        $user = Auth::user();
        $owner = RestaurantOwner::where('user_id', $user->id)->firstOrFail();
        return Restaurant::where('owner_id', $owner->id)->firstOrFail();
    }

    public function getUserOrders()
    {
        $restaurant = $this->getRestaurantOwner();
        $query = Order::with('user.customer') // Eager load user to access address
            ->where('restaurant_id', $restaurant->id);

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
        $order->status = 'delivered';
        $order->save();

        return $order;
    }

    public function cancelOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->status = 'canceled';
        $order->save();

        return $order;
    }
}
