<?php

namespace App\Http\Controllers\Orders;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Services\Orders\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderDashboardController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
{
    $orders = $this->orderService->getUserOrders();

    $formattedOrders = $orders->getCollection()->map(function ($order) {
        return [
            'id' => $order->id,
            'user_id' => $order->user_id,
            'user_name' => $order->user->first_name ?? null,
            'user_phone' => $order->user->phone_number ?? null,
            'user_address' => $order->user->customer->address ?? null, // If address is in the user model
            'restaurant_id' => $order->restaurant_id,
            'branch_id' => $order->branch_id,
            'total_amount' => $order->total_amount,
            'status' => $order->status,
            'order_type' => $order->order_type,
            'delivery_charges' => $order->delivery_charges,
            'estimated_delivery_time' => $order->estimated_delivery_time,
            'created_at' => $order->created_at,
            'updated_at' => $order->updated_at,
        ];
    });

    return Helpers::sendSuccessResponse(200, 'Orders Fetched Successfully', [
        'current_page' => $orders->currentPage(),
        'data' => $formattedOrders,
        'total' => $orders->total(),
        'last_page' => $orders->lastPage(),
    ]);
}
}