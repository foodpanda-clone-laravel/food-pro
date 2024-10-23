<?php

namespace App\Services\Customer;

use App\DTO\Customer\FavoritesDTO;
use App\DTO\Rating\RatingDTO;
use App\DTO\User\CustomerDTO;
use App\Helpers\Helpers;
use App\Http\Resources\Customer\FeedbackResource;
use App\Http\Resources\Customer\OrderDetailsResource;
use App\Http\Resources\DealResource;
use App\Http\Resources\MenuResources\MenuResource;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Customer\FavoriteRestaurantsResource;
use App\Http\Resources\Restaurant\RestaurantResource;
use App\Interfaces\Customer\CustomerServiceInterface;
use App\Models\Customer\Favourite;
use App\Models\Customer\Reward;
use App\Models\Menu\Deal\Deal;
use App\Models\Orders\Order;
use App\Models\Rating\Rating;
use App\Models\Restaurant\Restaurant;
use App\Models\User\Customer;
use App\Models\User\User;
use App\Pipelines\ResaurantsFilterPipeline;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CustomerService implements CustomerServiceInterface
{

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

  public function getFavoriteItems()
  {
    $user = auth()->user();
    $customer = $user->customer;

    $favoriteRestaurantIds = Favourite::where('customer_id', $customer->id)
      ->pluck('restaurant_id');

    $restaurants = Restaurant::whereIn('id', $favoriteRestaurantIds)
      ->with('ratings')
      ->get();

    return FavoriteRestaurantsResource::collection($restaurants);
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

  public function addFavoriteRestaurant($data)
  {
    $user = auth()->user();
    $customer = $user->customer;

    $exists = Favourite::where('customer_id', $customer->id)
      ->where('restaurant_id', $data->restaurant_id)
      ->exists();

    if (!$exists) {
      Favourite::create((new FavoritesDTO($data))->toArray());
    }

    return $this->getFavoriteItems();
  }
  public function removeFavoriteRestaurant($data)
  {
    $user = auth()->user();
    $customer = $user->customer;

    Favourite::where('customer_id', $customer->id)
      ->where('restaurant_id', $data->restaurant_id)
      ->delete();

    return $this->getFavoriteItems();
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

  public function getOrderDetails($orderId)
  {
      try{
          $user = auth()->user();
          $customer = $user->customer;

          $order = Order::where('id', $orderId)
              ->where('user_id', $customer->user_id)
              ->with([
                  'orderItems.menuItem',
                  'restaurant',
                  'branch',
              ])->firstOrFail();
          return new OrderDetailsResource($order);

      }
      catch(\Exception $e){
          dd($e->getMessage());
          return false;
        }
  }


  public function submitFeedback($data)
  {
      try{
          $user = auth()->user();
          $customer = $user->customer;

          if (!$customer) {
              throw new \Exception("Customer record not found for the logged-in user.");
          }
          $feedback = Rating::create((new RatingDTO($data))->toArray());

          // Return the feedback response using FeedbackResource
          return new FeedbackResource($feedback);

      }
      catch(\Exception $e){
          dd($e);
          return false;
      }
    }


  public function getAllRestaurants()
  {
    $query = Restaurant::query()
      ->with(['branches:restaurant_id,delivery_fee,delivery_time', 'ratings', 'deals']);
    $filteredRestaurants = ResaurantsFilterPipeline::apply($query, request()->all())->get();

    return RestaurantResource::collection($filteredRestaurants);
  }

  public function getDeals()
  {
    $deals = Deal::with([
      'restaurant:id,name,logo_path,cuisine',
      'restaurant.ratings' // Load ratings through the restaurant
    ])
      ->select('id', 'name', 'restaurant_id', 'branch_id', 'discount')
      ->get();

    return DealResource::collection($deals);
  }



}
