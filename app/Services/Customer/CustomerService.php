<?php

namespace App\Services\Customer;

use App\DTO\CustomerDTO;
use App\Helpers\Helpers;
use App\Interfaces\Customer\CustomerServiceInterface;
use App\Models\Customer\Favourite;
use App\Models\Customer\Reward;
use App\Models\Menu\Menu;
use App\Models\Orders\Order;
use App\Models\Restaurant\Rating;
use App\Models\Restaurant\Restaurant;
use App\Models\User\Customer;
use Illuminate\Http\Response;

class CustomerService implements CustomerServiceInterface
{

  public function updateProfile($userId, $validatedData)
  {
    $user = User::findOrFail($userId);
    $user->update($validatedData);

    // If there are any customer-specific fields (like address)
    $customerFields = array_intersect_key($validatedData, array_flip(['address', 'delivery_address', 'payment_method']));

    if (!empty($customerFields)) {
      $customer = Customer::where('user_id', $userId)->firstOrFail();
      $customer->update($customerFields);
    }
  }
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

    $order = Order::findOrFail($data['order_id']);

    $feedback = Rating::create([
      'order_id' => $data['order_id'],
      'restaurant_id' => $order->restaurant_id,
      'user_id' => $customer->user_id,
      'feedback' => $data['review'],
      'stars' => $data['rating'],
    ]);

    return [
      'feedback' => $feedback,
      'restaurant_id' => $order->restaurant_id
    ];
  }

  public function getAllRestaurants()
  {
    $query = Restaurant::query()->with('branches:restaurant_id,delivery_fee,delivery_time');

    // Apply filters using the pipeline
    $filteredRestaurants = FilterPipeline::apply($query, request()->all())->get();

    return $filteredRestaurants->map(function ($restaurant) {
      return [
        'image' => $restaurant->logo_path,
        'name' => $restaurant->name,
        'cuisine' => $restaurant->cuisine,
        'deliveryTime' => optional($restaurant->branches->first())->delivery_time ?? 'N/A',
        'deliveryFee' => optional($restaurant->branches->first())->delivery_fee ?? 0,
        'opening_time' => $restaurant->opening_time,
        'closing_time' => $restaurant->closing_time,
        'business_type' => $restaurant->business_type,
      ];
    });
  }

  public function getDeals()
  {
    $deals = Deal::with([
      'restaurant:id,name,logo_path,cuisine',
    ])
      ->select('id', 'name', 'restaurant_id', 'branch_id', 'discount')
      ->get()
      ->map(function ($deal) {

        $averageRating = Rating::where('restaurant_id', $deal->restaurant_id)
          ->select(DB::raw('AVG(stars) as average_rating'))
          ->groupBy('restaurant_id')
          ->pluck('average_rating')
          ->first() ?? 0;

        return [
          'id' => $deal->id,
          'name' => $deal->name,
          'restaurant_id' => $deal->restaurant_id,
          'branch_id' => $deal->branch_id,
          'discount' => $deal->discount,
          'average_rating' => round($averageRating, 2),
          'restaurant_name' => optional($deal->restaurant)->name ?? 'Unknown',
          'restaurant_logo' => optional($deal->restaurant)->logo_path ?? 'N/A',
          'restaurant_cuisine' => optional($deal->restaurant)->cuisine ?? 'N/A',
        ];
      });

    return $deals;
  }

}
