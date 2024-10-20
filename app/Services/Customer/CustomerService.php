<?php

namespace App\Services\Customer;

use App\DTO\User\CustomerDTO;
use App\Helpers\Helpers;
use App\Http\Resources\MenuResources\MenuResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Restaurant\RestaurantResource;
use App\Interfaces\Customer\CustomerServiceInterface;
use App\Models\Customer\Favourite;
use App\Models\Customer\Reward;
use App\Models\Menu\Deal\Deal;
use App\Models\Orders\Order;
use App\Models\Restaurant\Rating;
use App\Models\Restaurant\Restaurant;
use App\Models\User\Customer;
use App\Models\User\User;
use App\Pipelines\FilterPipeline;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
  public function getOrderHistory()
  {
    $user = auth()->user();
    $customer = $user->customer;

    $orders = Order::where('user_id', $customer->user_id)
      ->where('status', 'delivered')
      ->with(['orderItems.menuItem', 'restaurant', 'branch', 'rating'])
      ->get();

    return OrderResource::collection($orders)->additional(['showRating' => true]);
  }

  public function getMenusByRestaurant($restaurantId)
  {
    $restaurant = Restaurant::with([
      'menus.menuItems'
    ])->findOrFail($restaurantId);

    return new MenuResource($restaurant);
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

  public function getRewards()
  {
    $userId = auth()->user()->id;

    return Reward::where('user_id', $userId)->with('badge')->get();
  }

  public function usePoints($pointsToUse)
  {
    $userId = auth()->user()->id;

    $reward = Reward::where('user_id', $userId)->sum('points');

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

  public function getProfile($userId)
  {
    return Customer::with('user:id,first_name,last_name,phone_number,email,email_verified_at,created_at,updated_at')
      ->where('user_id', $userId)
      ->firstOrFail();
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

  public function getActiveOrder()
  {
    $user = auth()->user();
    $customer = $user->customer;

    $activeOrder = Order::where('user_id', $customer->user_id)
      ->where('status', 'in progress')
      ->with(['orderItems.menuItem', 'restaurant', 'branch', 'rating'])
      ->first();

    return $activeOrder;
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
    $query = Restaurant::query()
      ->with(['branches:restaurant_id,delivery_fee,delivery_time', 'ratings', 'deals']);
    $filteredRestaurants = FilterPipeline::apply($query, request()->all())->get();

    return RestaurantResource::collection($filteredRestaurants);
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

        $restaurantLogoUrl = $deal->restaurant && $deal->restaurant->logo_path
          ? Storage::url($deal->restaurant->logo_path)
          : null;

        return [
          'id' => $deal->id,
          'name' => $deal->name,
          'restaurant_id' => $deal->restaurant_id,
          'branch_id' => $deal->branch_id,
          'discount' => $deal->discount,
          'average_rating' => round($averageRating, 2),
          'restaurant_name' => optional($deal->restaurant)->name ?? 'Unknown',
          'restaurant_logo' => $restaurantLogoUrl ?? 'N/A',
          'restaurant_cuisine' => optional($deal->restaurant)->cuisine ?? 'N/A',
        ];
      });

    return $deals;
  }


}
