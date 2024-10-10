<?php

namespace App\Http\Controllers\Customer;

use App\Services\Customer\CustomerService;
use App\Helpers\Helpers;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

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

    public function searchRestaurant(Request $request)
    {
        try {
            $validated = $request->validate([
                'search_term' => 'required|string|min:1',
            ]);
            $restaurants = $this->customerService->searchRestaurant($validated['search_term']);
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

    public function usePointsAtCheckout($customerId, Request $request)
    {
        try {
            $validated = $request->validate([
                'points' => 'required|integer|min:1',
            ]);
            $monetaryValue = $this->customerService->usePoints($customerId, $validated['points']);
            return Helpers::sendSuccessResponse(200, 'Points redeemed successfully', ['monetary_value' => $monetaryValue]);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to use points at checkout', ['request_id' => $requestId]);
        }
    }

    public function updateDeliveryAddress($customerId, Request $request)
    {
        try {
            $validated = $request->validate([
                'delivery_address' => 'required|string|min:5',
            ]);
            $this->customerService->updateDeliveryAddress($customerId, $validated['delivery_address']);
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

    public function addFavoriteRestaurant($customerId, Request $request)
    {
        try {
            $validated = $request->validate([
                'restaurant_id' => 'required|integer|exists:restaurants,id',
            ]);
            $this->customerService->addFavoriteRestaurant($customerId, $validated['restaurant_id']);
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

    public function submitFeedback($customerId, Request $request)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'required|exists:orders,id',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'nullable|string',
            ]);
            $feedback = $this->customerService->submitFeedback($customerId, $validated);
            return Helpers::sendSuccessResponse(200, 'Feedback submitted successfully', $feedback);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to submit feedback', ['request_id' => $requestId]);
        }
    }

    public function viewAllRestaurants()
    {
        try {
            $restaurants = $this->customerService->getAllRestaurants();
            return Helpers::sendSuccessResponse(200, 'All restaurants retrieved successfully', $restaurants);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to retrieve all restaurants', ['request_id' => $requestId]);
        }
    }
}