<?php

namespace App\Http\Controllers\Customer;

use App\Helpers\Helpers;
use App\Http\Requests\CartRequests\CheckoutRequest;
use App\Http\Requests\OrderRequests\ViewOrderDetailsRequest;
use App\Http\Resources\CartResources\CartSummaryResource;
use App\Http\Resources\Order\OrderResource;
use App\Services\Customer\CustomerOrderService;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends CustomerController
{

    public function orderHistory()
    {
        $orders = $this->customerService->getOrderHistory();

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Order history retrieved successfully', $orders);
    }

    public function activeOrder()
    {
        $activeOrder = $this->customerService->getActiveOrder();

        if ($activeOrder) {
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Active order retrieved successfully', new OrderResource($activeOrder));
        }

        return Helpers::sendFailureResponse(Response::HTTP_NOT_FOUND, 'No active order found');
    }

    public function viewOrderDetails(ViewOrderDetailsRequest $request)
    {
        $orderDetails = $this->customerService->getOrderDetails($request);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Order details retrieved successfully', $orderDetails);
    }

    public function checkout(CustomerOrderService $customerOrderService)
    {
        $data = $customerOrderService->checkout();
        $result=  new CartSummaryResource((object)$data);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Order summary', $result);
    }
    public function createOrder(CheckoutRequest $request, CustomerOrderService $customerOrderService)
    {

        $result = $customerOrderService->createOrder($request);
        if ($result) {
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Order created successfully', $result);
        } else {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Could not process your order');
        }

    }


}
