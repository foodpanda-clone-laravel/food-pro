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

        // Find the restaurant owner
        $owner = RestaurantOwner::where('user_id', $user->id)->firstOrFail();

        // Find the restaurant associated with the owner
        $restaurant = Restaurant::where('owner_id', $owner->id)->firstOrFail();

        return $restaurant;
    }
    public function getUserOrders()
    {
        $restaurant=$this->getRestaurantOwner();
        $query = Order::where('restaurant_id', $restaurant->id );
       // Log::info('Fetching orders for user ID: ' . $userId, ['query' => $query->toSql()]);
        return app(Pipeline::class)
            ->send($query)
            ->through([
                \App\Pipelines\Filters\StatusFilter::class,
                \App\Pipelines\Filters\OrderTypeFilter::class,
            ])
            ->thenReturn()
            ->paginate(10);
    }
    
}