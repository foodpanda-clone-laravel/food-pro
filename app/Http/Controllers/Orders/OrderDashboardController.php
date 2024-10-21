<?php

namespace App\Http\Controllers\Orders;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequests\UpdateOrderStatusRequest;
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

        $formattedOrders = $orders->map(function ($order) {
            $orderItems = $order->orderItems->map(function ($item) {
                return [
                    'menu_item_id' => $item->menu_item_id,
                    'quantity' => $item->quantity,
                    'image_file' => $item->menuItem->image_file ?? null, // Accessing image_file from menu_item
                ];
            });

            return [
                'id' => $order->id,
                'user_id' => $order->user_id,
                'user_name' => $order->user->first_name ?? null,
                'user_phone' => $order->user->phone_number ?? null,
                'user_address' => $order->user->customer->address ?? null,
                'restaurant_id' => $order->restaurant_id,
                'branch_id' => $order->branch_id,
                'total_amount' => $order->total_amount,
                'status' => $order->status,
                'order_type' => $order->order_type,
                'delivery_charges' => $order->delivery_charges,
                'estimated_delivery_time' => $order->estimated_delivery_time,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'order_items' => $orderItems, // Include order items in the response
            ];
        });

        return Helpers::sendSuccessResponse(200, 'Orders Fetched Successfully', [
            'data' => $formattedOrders,
        ]);
    }





    public function updateOrderStatus(UpdateOrderStatusRequest $request)
    {
        $orderId = $request->input('order_id');

        if ($request->status === 'confirm') {
            $order = $this->orderService->confirmOrder($orderId);
            return Helpers::sendSuccessResponse(200, 'Order confirmed and marked as delivered successfully', $order);
        } elseif ($request->status === 'cancel') {
            $order = $this->orderService->cancelOrder($orderId);
            return Helpers::sendSuccessResponse(200, 'Order canceled successfully', $order);
        }

        return Helpers::sendFailureResponse(400, 'Invalid status');
    }

}

