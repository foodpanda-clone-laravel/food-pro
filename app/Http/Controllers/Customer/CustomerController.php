<?php

namespace App\Http\Controllers\Customer;

use App\Services\Customer\CustomerService;
use App\Helpers\Helpers;
use App\Http\Requests\BaseRequest;
use App\DTO\CustomerDTO;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
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
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Order history retrieved successfully', $orders);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to retrieve order history');
        }
    }

    public function viewMenus()
    {
        try {
            $menus = $this->customerService->getMenus();
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Menus retrieved successfully', $menus);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to retrieve menus');
        }
    }

    public function searchRestaurant(Request $request)
    {
        $validatedData = $request->getValidatedData();

        if ($validator->fails()) {
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST, 'Validation failed', $validator->errors());
        }

        try {
            $restaurants = $this->customerService->searchRestaurant($request->input('search_term'));
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurants retrieved successfully', $restaurants);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to search restaurants');
        }
    }

    public function favoriteItems($customerId)
    {
        try {
            $favoriteRestaurants = $this->customerService->getFavoriteItems($customerId);
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Favorite restaurants retrieved successfully', $favoriteRestaurants);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to retrieve favorite restaurants');
        }
    }

    public function viewRewards($customerId)
    {
        try {
            $rewards = $this->customerService->getRewards($customerId);
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Rewards retrieved successfully', $rewards);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to retrieve rewards');
        }
    }

    public function usePointsAtCheckout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'points' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST, 'Validation failed', $validator->errors());
        }

        try {
            $monetaryValue = $this->customerService->usePoints($request->input('points'));
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Points redeemed successfully', ['monetary_value' => $monetaryValue]);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to use points at checkout');
        }
    }

    public function updateDeliveryAddress(BaseRequest $request, $customerId)
    {
        try {
            // Use the custom method getValidatedData() instead of Validator
            $validatedData = $request->getValidatedData();

            // Create DTO from validated data
            $customerDTO = new CustomerDTO(
                $validatedData['address'],
                $validatedData['delivery_address'],
                $validatedData['favorites'] ?? null
            );

            // Call the service with the DTO
            $this->customerService->updateCustomerInfo($customerId, $customerDTO);

            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Delivery address updated successfully');
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to update delivery address');
        }
    }

    public function viewProfile($customerId)
    {
        try {
            $customer = $this->customerService->getProfile($customerId);
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Customer profile retrieved successfully', $customer);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to retrieve customer profile');
        }
    }

    public function addFavoriteRestaurant(BaseRequest $request, $customerId)
    {
        try {
            $validatedData = $request->getValidatedData();

            // Call service method to add favorite restaurant
            $this->customerService->addFavoriteRestaurant($customerId, $validatedData['restaurant_id']);

            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant added to favorites successfully');
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to add restaurant to favorites');
        }
    }

    public function removeFavoriteRestaurant($customerId, $restaurantId)
    {
        try {
            $this->customerService->removeFavoriteRestaurant($customerId, $restaurantId);
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant removed from favorites successfully');
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to remove restaurant from favorites');
        }
    }

    public function activeOrder($customerId)
    {
        try {
            $activeOrder = $this->customerService->getActiveOrder($customerId);
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Active order retrieved successfully', $activeOrder);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to retrieve active order');
        }
    }

    public function submitFeedback(BaseRequest $request, $customerId)
    {
        try {
            $validatedData = $request->getValidatedData();

            // Call the service method
            $feedback = $this->customerService->submitFeedback($customerId, $validatedData);

            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Feedback submitted successfully', $feedback);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to submit feedback');
        }
    }

    public function viewAllRestaurants()
    {
        try {
            $restaurants = $this->customerService->getAllRestaurants();
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'All restaurants retrieved successfully', $restaurants);
        } catch (Exception $e) {
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Failed to retrieve all restaurants');
        }
    }
}