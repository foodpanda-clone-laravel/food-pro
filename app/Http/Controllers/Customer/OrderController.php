<?php

namespace App\Http\Controllers\Customer;

use App\Services\Customer\CustomerService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    protected $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function orderHistory(Request $request)
    {
        $customerId = $request->get('customer_id');
        $orders = $this->customerService->getOrderHistory($customerId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Order history retrieved successfully', $orders);
    }

    public function activeOrder(Request $request)
    {
        $customerId = $request->get('customer_id');
        $activeOrder = $this->customerService->getActiveOrder($customerId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Active order retrieved successfully', $activeOrder);
    }

    public function createOrder()
    {

    }
    public function cancelOrder()
    {

    }

}
