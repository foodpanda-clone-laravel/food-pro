<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Helpers\Helpers;
use App\Http\Requests\SearchRestaurantRequest;
use App\Http\Requests\AddFavoriteRestaurantRequest;
use App\Http\Requests\UsePointsRequest;
use App\Http\Requests\UpdateDeliveryAddressRequest;
use App\Http\Requests\SubmitFeedbackRequest;
use Exception;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function orderHistory($customerId)
    {
        try {
            $orders = $this->customerService->getOrderHistory($customerId);
            return Helpers::sendSuccessResponse(200, 'Order history retrieved successfully', $orders);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to retrieve order history', ['request_id' => $requestId]);
        }
    }

    public function viewMenus()
    {
        try {
            $menus = $this->customerService->getMenus();
            return Helpers::sendSuccessResponse(200, 'Menus retrieved successfully', $menus);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to retrieve menus', ['request_id' => $requestId]);
        }
    }

    public function searchRestaurant(SearchRestaurantRequest $request)
    {
        try {
            $restaurants = $this->customerService->searchRestaurant($request->input('search_term'));
            return Helpers::sendSuccessResponse(200, 'Restaurants retrieved successfully', $restaurants);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to search restaurants', ['request_id' => $requestId]);
        }
    }

    public function favoriteItems($customerId)
    {
        try {
            $favoriteRestaurants = $this->customerService->getFavoriteItems($customerId);
            return Helpers::sendSuccessResponse(200, 'Favorite restaurants retrieved successfully', $favoriteRestaurants);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to retrieve favorite restaurants', ['request_id' => $requestId]);
        }
    }

    public function viewRewards($customerId)
    {
        try {
            $rewards = $this->customerService->getRewards($customerId);
            return Helpers::sendSuccessResponse(200, 'Rewards retrieved successfully', $rewards);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to retrieve rewards', ['request_id' => $requestId]);
        }
    }

    public function usePointsAtCheckout($customerId, UsePointsRequest $request)
    {
        try {
            $monetaryValue = $this->customerService->usePoints($customerId, $request->input('points'));
            return Helpers::sendSuccessResponse(200, 'Points redeemed successfully', ['monetary_value' => $monetaryValue]);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to use points at checkout', ['request_id' => $requestId]);
        }
    }

    public function updateDeliveryAddress($customerId, UpdateDeliveryAddressRequest $request)
    {
        try {
            $this->customerService->updateDeliveryAddress($customerId, $request->input('delivery_address'));
            return Helpers::sendSuccessResponse(200, 'Delivery address updated successfully');
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to update delivery address', ['request_id' => $requestId]);
        }
    }

    public function viewProfile($customerId)
    {
        try {
            $customer = $this->customerService->getProfile($customerId);
            return Helpers::sendSuccessResponse(200, 'Customer profile retrieved successfully', $customer);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to retrieve customer profile', ['request_id' => $requestId]);
        }
    }

    public function addFavoriteRestaurant($customerId, AddFavoriteRestaurantRequest $request)
    {
        try {
            $this->customerService->addFavoriteRestaurant($customerId, $request->input('restaurant_id'));
            return Helpers::sendSuccessResponse(200, 'Restaurant added to favorites successfully');
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to add restaurant to favorites', ['request_id' => $requestId]);
        }
    }

    public function removeFavoriteRestaurant($customerId, $restaurantId)
    {
        try {
            $this->customerService->removeFavoriteRestaurant($customerId, $restaurantId);
            return Helpers::sendSuccessResponse(200, 'Restaurant removed from favorites successfully');
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to remove restaurant from favorites', ['request_id' => $requestId]);
        }
    }

    public function activeOrder($customerId)
    {
        try {
            $activeOrder = $this->customerService->getActiveOrder($customerId);
            if (!$activeOrder) {
                return Helpers::sendFailureResponse(404, 'No active order found for the customer');
            }
            return Helpers::sendSuccessResponse(200, 'Active order retrieved successfully', $activeOrder);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to retrieve active order', ['request_id' => $requestId]);
        }
    }

    public function submitFeedback($customerId, SubmitFeedbackRequest $request)
    {
        try {
            $feedback = $this->customerService->submitFeedback($customerId, $request->validated());
            return Helpers::sendSuccessResponse(200, 'Feedback submitted successfully', $feedback);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to submit feedback', ['request_id' => $requestId]);
        }
    }
}
