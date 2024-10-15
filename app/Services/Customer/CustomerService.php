<?php

namespace App\Services\Customer;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\Reward;
use App\Models\Rating;
use App\Models\Favourite;
use App\DTO\CustomerDTO;
use App\Helpers\Helpers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Str;

use App\Interfaces\Customer\CustomerServiceInterface;

class CustomerService implements CustomerServiceInterface
{
  public function getOrderHistory($customerId)
  {
    $customer = Customer::findOrFail($customerId);
    return Order::where('user_id', $customer->user_id)
      ->with(['orderItems.menuItem'])
      ->get();
  }

  public function getMenus()
  {
    return Menu::with('restaurant')->get();
  }

  public function searchRestaurant($searchTerm)
  {
    return Restaurant::where('name', 'like', "%{$searchTerm}%")->get();
  }

  public function getFavoriteItems($customerId)
  {
    $favoriteRestaurantIds = Favourite::where('customer_id', $customerId)
      ->pluck('restaurant_id');

    $restaurants = Restaurant::whereIn('id', $favoriteRestaurantIds)
      ->select('id', 'name', 'logo_path', 'cuisine', 'opening_time', 'closing_time')
      ->get();

    return $restaurants;
  }

  public function getRewards($customerId)
  {
    $customer = Customer::findOrFail($customerId);
    return Reward::where('user_id', $customer->user_id)->with('badge')->get();
  }

  public function usePoints($customerId, $pointsToUse)
  {
    $customer = Customer::findOrFail($customerId);
    $reward = Reward::where('user_id', $customer->user_id)->sum('points');
    if ($pointsToUse > $reward) {
      return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST, 'Not enough points');
    }
    return $this->convertPointsToMoney($pointsToUse);
  }

  private function convertPointsToMoney($points)
  {
    return $points * 0.01;
  }

  public function updateCustomerInfo($customerId, CustomerDTO $customerDTO)
  {
    $customer = Customer::findOrFail($customerId);

    if ($customerDTO->address) {
      $customer->address = $customerDTO->address;
    }
    if ($customerDTO->delivery_address) {
      $customer->delivery_address = $customerDTO->delivery_address;
    }
    if ($customerDTO->favorites !== null) {
      $customer->favorites = is_array($customerDTO->favorites) ? implode(',', $customerDTO->favorites) : $customerDTO->favorites;
    }

    $customer->save();
  }

  public function getProfile($customerId)
  {
    return Customer::findOrFail($customerId);
  }

  public function addFavoriteRestaurant($customerId, $restaurantId)
  {
    $exists = Favourite::where('customer_id', $customerId)
      ->where('restaurant_id', $restaurantId)
      ->exists();

    if (!$exists) {
      Favourite::create([
        'customer_id' => $customerId,
        'restaurant_id' => $restaurantId
      ]);
    }
    return $this->getFavoriteItems($customerId);
  }

  public function removeFavoriteRestaurant($customerId, $restaurantId)
  {
    Favourite::where('customer_id', $customerId)
      ->where('restaurant_id', $restaurantId)
      ->delete();

    return $this->getFavoriteItems($customerId);
  }

  public function getActiveOrder($customerId)
  {
    $customer = Customer::findOrFail($customerId);
    return Order::where('user_id', $customer->user_id)
      ->where('status', 'in progress')
      ->with('orderItems.menuItem')
      ->first();
  }

  public function submitFeedback($customerId, $data)
  {
    $customer = Customer::findOrFail($customerId);
    return Rating::create([
      'order_id' => $data['order_id'],
      'user_id' => $customer->user_id,
      'feedback' => $data['review'],
      'stars' => $data['rating'],
    ]);
  }

  public function getAllRestaurants()
  {
    return Restaurant::all();
  }
}