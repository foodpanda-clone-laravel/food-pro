<?php

namespace App\Http\Controllers\Customer;

use App\Models\Restaurant\Restaurant;
use App\Http\Resources\ProfileResource;
use App\Services\Customer\CustomerService;
use App\Helpers\Helpers;
use App\DTO\CustomerDTO;
use Illuminate\Http\Request;
use App\Models\User\User;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CustomerRequests\UpdateCustomerAddressRequest;
use App\Http\Requests\CustomerRequests\AddFavoriteRestaurantRequest;
use App\Http\Requests\CustomerRequests\UpdateProfileRequest;
use App\Http\Requests\CustomerRequests\UsePointsRequest;
use App\Http\Requests\CustomerRequests\SubmitFeedbackRequest;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    protected $customerService;
    protected $customer;
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;

        if (auth()->check()) {
            $user = Auth::user();
            $this->customer = $user->customer;
        }
    }

    public function editProfile(UpdateProfileRequest $request)
    {
        $userId = auth()->user()->id;
        $validatedData = $request->getValidatedData();


        $this->customerService->updateProfile($userId, $validatedData);

        $updatedUser = User::with('customer')->find($userId);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Profile updated successfully', $updatedUser);
    }

    public function viewMenus($restaurantId)
    {
        $menus = $this->customerService->getMenusByRestaurant($restaurantId);
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

    public function viewRewards()
    {
        $rewards = $this->customerService->getRewards();

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Rewards retrieved successfully', $rewards);
    }

    public function usePointsAtCheckout(UsePointsRequest $request)
    {
        $validatedData = $request->getValidatedData();

        $monetaryValue = $this->customerService->usePoints($validatedData['points']);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Points redeemed successfully', ['monetary_value' => $monetaryValue]);
    }


    public function updateCustomerAddress(UpdateCustomerAddressRequest $request)
    {
        $customerId = $request->get('customer_id');
        $validatedData = $request->getValidatedData();
        $isDefaultAddress = $request->routeIs('updateCustomerDefaultAddress');

        $data = [
            'user_id' => $customerId,
            'address' => $validatedData['address'] ?? null,
            'delivery_address' => $isDefaultAddress ? null : ($validatedData['delivery_address'] ?? null),
            'favorites' => $validatedData['favorites'] ?? null
        ];

        // Ensure either address or delivery_address is present
        if (is_null($data['address']) && is_null($data['delivery_address'])) {
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST, 'Either address or delivery address must be provided.');
        }

        $customerDTO = new CustomerDTO($data);

        $this->customerService->updateCustomerInfo($customerId, $customerDTO);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Customer address updated successfully');
    }

    public function viewProfile()
    {
        $userId = auth()->user()->id;
        $customer = $this->customerService->getProfile($userId);

        return Helpers::sendSuccessResponse(
            Response::HTTP_OK,
            'Customer profile retrieved successfully',
            new ProfileResource($customer)
        );
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
    // public function viewRestaurantById(Request $request)
    // {
    //     $restaurant = $this->customerService->viewRestaurantById($request->all());
    //     return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant retrieved successfully', $restaurant);
    // }

    public function viewDeals()
    {
        $deals = $this->customerService->getDeals();
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Deals retrieved successfully', $deals);
    }

}
