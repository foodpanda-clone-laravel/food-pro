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
        $query = Order::with(['user.customer', 'orderItems.menuItem']) // Eager load necessary relationships
            ->where('restaurant_id', $restaurant->id);
        return app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Pipelines\Filters\StatusFilter::class,
                \App\Pipelines\Filters\OrderTypeFilter::class,
            ])
            ->thenReturn()
            ->get(); // Fetch all orders as a collection
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
