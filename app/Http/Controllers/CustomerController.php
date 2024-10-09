<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Reward;
use App\Models\Rating;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;
use App\Http\Requests\SearchRestaurantRequest;
use App\Http\Requests\AddFavoriteRestaurantRequest;
use App\Http\Requests\UsePointsRequest;
use App\Http\Requests\UpdateDeliveryAddressRequest;
use App\Http\Requests\SubmitFeedbackRequest;


class CustomerController extends Controller
{
    public function orderHistory($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);

            $orders = Order::where('user_id', $customer->user_id)
                ->with(['orderItems.menuItem']) // Eager Loading
                ->get();

            return Helpers::sendSuccessResponse(200, 'Order history retrieved successfully', $orders);
        } catch (Exception $e) {
            $requestId = Str::uuid(); // Generate a unique request ID
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to retrieve order history', ['request_id' => $requestId]);
        }
    }

    public function viewMenus()
    {
        try {
            $menus = Menu::with('restaurant') // Eager load restaurant information
                ->get();

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
            $searchTerm = $request->input('search_term');
            $restaurants = Restaurant::where('name', 'like', "%{$searchTerm}%")->get();
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
            $customer = Customer::findOrFail($customerId);

            // Assuming 'favorites' is a comma-separated list of restaurant IDs
            $favorites = explode(',', $customer->favorites);

            // Fetch the favorite restaurants based on the stored IDs
            $favoriteRestaurants = Restaurant::whereIn('id', $favorites)->get();

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
            $customer = Customer::findOrFail($customerId);

            $rewards = Reward::where('user_id', $customer->user_id)
                ->with('badge') // Eager load badge information
                ->get();

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
            $customer = Customer::findOrFail($customerId);
            $pointsToUse = $request->input('points');
            $reward = Reward::where('user_id', $customer->user_id)->sum('points');
            if ($pointsToUse > $reward) {
                return Helpers::sendFailureResponse(400, 'Not enough points', ['available_points' => $reward]);
            }
            $monetaryValue = $this->convertPointsToMoney($pointsToUse);
            return Helpers::sendSuccessResponse(200, 'Points redeemed successfully', ['monetary_value' => $monetaryValue]);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to use points at checkout', ['request_id' => $requestId]);
        }
    }

    private function convertPointsToMoney($points)
    {
        // Assuming 1 point = $0.01, modify as per business logic
        return $points * 0.01;
    }

    public function updateDeliveryAddress($customerId, UpdateDeliveryAddressRequest $request)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            $newAddress = $request->input('delivery_address');
            $customer->delivery_address = $newAddress;
            $customer->save();
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
            $customer = Customer::findOrFail($customerId);

            // Return the customer profile information
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
            $customer = Customer::findOrFail($customerId);
            $restaurantId = $request->input('restaurant_id');
            $favorites = explode(',', $customer->favorites);
            if (!in_array($restaurantId, $favorites)) {
                $favorites[] = $restaurantId;
            }
            $customer->favorites = implode(',', $favorites);
            $customer->save();
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
            $customer = Customer::findOrFail($customerId);

            // Remove the restaurant from the favorites list
            $favorites = explode(',', $customer->favorites);
            if (($key = array_search($restaurantId, $favorites)) !== false) {
                unset($favorites[$key]);
            }

            $customer->favorites = implode(',', $favorites);
            $customer->save();

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
            // Fetch the customer's active order (assuming 'in progress' is the status for active orders)
            $customer = Customer::findOrFail($customerId);
            $activeOrder = Order::where('user_id', $customer->user_id)
                ->where('status', 'in progress')
                ->with('orderItems.menuItem') // Eager load related order items and menu items
                ->first();

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
            $customer = Customer::findOrFail($customerId);
            $validated = $request->validated();
            $feedback = Rating::create([
                'order_id' => $validated['order_id'],
                'user_id' => $customer->user_id,
                'feedback' => $validated['review'],
                'stars' => $validated['rating']
            ]);
            return Helpers::sendSuccessResponse(200, 'Feedback submitted successfully', $feedback);
        } catch (Exception $e) {
            $requestId = Str::uuid();
            Helpers::createErrorLogs($e, $requestId);
            return Helpers::sendFailureResponse(500, 'Failed to submit feedback', ['request_id' => $requestId]);
        }
    }


}
