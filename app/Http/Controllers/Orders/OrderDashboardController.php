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
       // dd(vars: $user);
        $orders = $this->orderService->getUserOrders();
      

        return Helpers::sendSuccessResponse(200, 'Orders Fetched Successfully', $orders);
    }
}
