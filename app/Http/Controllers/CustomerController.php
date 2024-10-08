<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Reward;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Str;


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

    public function searchRestaurant(Request $request)
    {
        try {
            $searchTerm = $request->input('search_term');

            $restaurants = Restaurant::where('name', 'like', "%{$searchTerm}%")
                ->get();

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

    public function usePointsAtCheckout($customerId, Request $request)
    {
        try {
            $customer = Customer::findOrFail($customerId);

            // Assuming $request->input('points') contains the points the customer wants to redeem
            $pointsToUse = $request->input('points');

            $reward = Reward::where('user_id', $customer->user_id)
                ->sum('points'); // Sum all the customer's points

            if ($pointsToUse > $reward) {
                return Helpers::sendFailureResponse(400, 'Not enough points', ['available_points' => $reward]);
            }

            // Logic to deduct points and convert them to monetary value for checkout
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

    public function updateDeliveryAddress($customerId, Request $request)
    {
        try {
            $customer = Customer::findOrFail($customerId);

            // Assuming the new delivery address comes in the request
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
}
