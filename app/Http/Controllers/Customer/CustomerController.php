<?php

namespace App\Http\Controllers\Customer;

use App\Services\Customer\CustomerService;
use App\Helpers\Helpers;
use App\DTO\CustomerDTO;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Customer\UpdateCustomerAddressRequest;
use App\Http\Requests\Customer\AddFavoriteRestaurantRequest;
use App\Http\Requests\Customer\UsePointsRequest;
use App\Http\Requests\Customer\SubmitFeedbackRequest;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
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

    public function viewMenus()
    {
        $menus = $this->customerService->getMenus();
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Menus retrieved successfully', $menus);
    }

    public function searchRestaurant(Request $request)
    {
        $restaurants = $this->customerService->searchRestaurant($request->get('search_term'));
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurants retrieved successfully', $restaurants);
    }

    public function favoriteItems(Request $request)
    {
        $customerId = $request->get('customer_id');
        $favoriteRestaurants = $this->customerService->getFavoriteItems($customerId);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Favorite restaurants retrieved successfully', $favoriteRestaurants);
    }

    public function viewRewards(Request $request)
    {
        $customerId = $request->get('customer_id');
        $rewards = $this->customerService->getRewards($customerId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Rewards retrieved successfully', $rewards);
    }

    public function usePointsAtCheckout(UsePointsRequest $request)
    {
        $customerId = $request->get('customer_id');
        $validatedData = $request->getValidatedData();
        $monetaryValue = $this->customerService->usePoints($customerId, $validatedData['points']);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Points redeemed successfully', ['monetary_value' => $monetaryValue]);
    }

    public function updateCustomerAddress(UpdateCustomerAddressRequest $request)
    {
        $customerId = $request->get('customer_id');
        $validatedData = $request->getValidatedData();
        $isDefaultAddress = $request->routeIs('updateCustomerDefaultAddress');

        // Ensure at least one of address or delivery_address is provided
        if (empty($validatedData['address']) && empty($validatedData['delivery_address'])) {
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST, 'At least one of address or delivery address must be provided');
        }

        $customerDTO = new CustomerDTO(
            $validatedData['address'] ?? null,
            $isDefaultAddress ? null : ($validatedData['delivery_address'] ?? null),
            $validatedData['favorites'] ?? null
        );

        $this->customerService->updateCustomerInfo($customerId, $customerDTO);

        $updatedCustomer = $this->customerService->getProfile($customerId);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Customer address updated successfully', $updatedCustomer);
    }

    public function viewProfile(Request $request)
    {
        $customerId = $request->get('customer_id');
        $customer = $this->customerService->getProfile($customerId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Customer profile retrieved successfully', $customer);
    }

    public function addFavoriteRestaurant(AddFavoriteRestaurantRequest $request)
    {
        $customerId = $request->get('customer_id');
        $restaurantId = $request->get('restaurant_id');

        $this->customerService->addFavoriteRestaurant($customerId, $restaurantId);

        $favoriteRestaurants = $this->customerService->getFavoriteItems($customerId);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant added to favorites successfully', $favoriteRestaurants);
    }

    public function removeFavoriteRestaurant(Request $request)
    {
        $customerId = $request->get('customer_id');
        $restaurantId = $request->get('restaurant_id');

        $favoriteRestaurants = $this->customerService->removeFavoriteRestaurant($customerId, $restaurantId);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant removed from favorites successfully', $favoriteRestaurants);
    }

    public function activeOrder(Request $request)
    {
        $customerId = $request->get('customer_id');
        $activeOrder = $this->customerService->getActiveOrder($customerId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Active order retrieved successfully', $activeOrder);
    }

    public function submitFeedback(SubmitFeedbackRequest $request)
    {
        $customerId = $request->get('customer_id');
        $validatedData = $request->getValidatedData();
        $feedback = $this->customerService->submitFeedback($customerId, $validatedData);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Feedback submitted successfully', $feedback);
    }

    public function viewAllRestaurants()
    {
        $restaurants = $this->customerService->getAllRestaurants();
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'All restaurants retrieved successfully', $restaurants);
    }
}
