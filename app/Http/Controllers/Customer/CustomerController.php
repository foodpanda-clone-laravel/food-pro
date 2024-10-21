<?php

namespace App\Http\Controllers\Customer;

use App\Models\Restaurant\Restaurant;

use App\Services\Customer\CustomerService;
use App\Helpers\Helpers;

use Illuminate\Http\Request;
use App\Models\User\User;

use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\CustomerRequests\AddFavoriteRestaurantRequest;
use App\Http\Requests\CustomerRequests\UsePointsRequest;
use App\Http\Requests\CustomerRequests\SubmitFeedbackRequest;
use App\Http\Resources\FeedbackResource;
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

    public function favoriteItems()
    {
        $favoriteRestaurants = $this->customerService->getFavoriteItems();

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Favorite restaurants retrieved successfully', $favoriteRestaurants);
    }

    public function viewRewards()
    {
        $rewards = $this->customerService->getRewards();

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Rewards retrieved successfully', $rewards);
    }

    public function usePointsAtCheckout(UsePointsRequest $request)
    {
        $monetaryValue = $this->customerService->usePoints($request->points);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Points redeemed successfully', ['monetary_value' => $monetaryValue]);
    }


    public function addFavoriteRestaurant(AddFavoriteRestaurantRequest $request)
    {
        $restaurantId = $request->get('restaurant_id');

        // Use the logged-in customer's information
        $favoriteRestaurants = $this->customerService->addFavoriteRestaurant($restaurantId);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant added to favorites successfully', $favoriteRestaurants);
    }

    public function removeFavoriteRestaurant(Request $request)
    {
        $restaurantId = $request->get('restaurant_id');

        // Use the logged-in customer's information
        $favoriteRestaurants = $this->customerService->removeFavoriteRestaurant($restaurantId);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant removed from favorites successfully', $favoriteRestaurants);
    }
    public function submitFeedback(SubmitFeedbackRequest $request)
    {
        $feedback = $this->customerService->submitFeedback($request);

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Feedback submitted successfully', new FeedbackResource($feedback));
    }

    public function viewAllRestaurants()
    {
        $restaurants = $this->customerService->getAllRestaurants();

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'All restaurants retrieved successfully', $restaurants);
    }

    public function viewDeals()
    {
        $deals = $this->customerService->getDeals();
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Deals retrieved successfully', $deals);
    }

}
