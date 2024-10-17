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


        return Helpers::sendSuccessResponse(200, 'Orders Fetched Successfully', $orders);
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

