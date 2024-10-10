<?php

namespace App\Http\Controllers\Customer;

use App\Services\Customer\CustomerService;
use App\Helpers\Helpers;
use App\DTO\CustomerDTO;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests\Customer\UpdateCustomerAddressRequest;
use App\Http\Requests\Customer\AddFavoriteRestaurantRequest;
use App\Http\Requests\Customer\UsePointsRequest;
use App\Http\Requests\Customer\SubmitFeedbackRequest;
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

    public function favoriteItems($customerId)
    {
        $favoriteRestaurants = $this->customerService->getFavoriteItems($customerId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Favorite restaurants retrieved successfully', $favoriteRestaurants);
    }

    public function viewRewards($customerId)
    {
        $rewards = $this->customerService->getRewards($customerId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Rewards retrieved successfully', $rewards);
    }

    public function usePointsAtCheckout(UsePointsRequest $request, $customerId)
    {
        $validatedData = $request->getValidatedData();
        $monetaryValue = $this->customerService->usePoints($customerId, $validatedData['points']);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Points redeemed successfully', ['monetary_value' => $monetaryValue]);
    }

    public function updateCustomerAddress(UpdateCustomerAddressRequest $request, $customerId)
    {
        $validatedData = $request->getValidatedData();
        $isDefaultAddress = $request->routeIs('updateCustomerDefaultAddress');

        // Use route logic to determine if it's the default or delivery address being updated
        $customerDTO = new CustomerDTO(
            $validatedData['address'],
            $isDefaultAddress ? null : $validatedData['delivery_address'],
            $validatedData['favorites'] ?? null
        );

        $this->customerService->updateCustomerInfo($customerId, $customerDTO);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Customer address updated successfully');
    }

    public function viewProfile($customerId)
    {
        $customer = $this->customerService->getProfile($customerId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Customer profile retrieved successfully', $customer);
    }

    public function addFavoriteRestaurant(AddFavoriteRestaurantRequest $request, $customerId)
    {
        $validatedData = $request->getValidatedData();
        $this->customerService->addFavoriteRestaurant($customerId, $validatedData['restaurant_id']);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant added to favorites successfully');
    }

    public function removeFavoriteRestaurant($customerId, $restaurantId)
    {
        $this->customerService->removeFavoriteRestaurant($customerId, $restaurantId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant removed from favorites successfully');
    }

    public function activeOrder($customerId)
    {
        $activeOrder = $this->customerService->getActiveOrder($customerId);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Active order retrieved successfully', $activeOrder);
    }

    public function submitFeedback(SubmitFeedbackRequest $request, $customerId)
    {
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