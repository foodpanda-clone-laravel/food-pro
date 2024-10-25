<?php

namespace App\Services\Rating;

use App\Http\Requests\RestaurantRequests\ViewRatingsRequest;
use App\Http\Resources\Rating\RatingResource;
use App\Http\Resources\Rating\RestaurantOwnerRatingResource;
use App\Interfaces\RatingServiceInterface;
use App\Models\Rating\Rating;
use App\Models\Restaurant\Restaurant;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;

class RatingService implements RatingServiceInterface
{
    public function index(){

    }
    // rating endpoint for admin
    public function viewMyRestaurantRating(){
        $user = Auth::user();
        $restaurant = $user->restaurantOwner->restaurant;

        $ratings = Rating::where('restaurant_id', $restaurant->id)
        ->with(['user', 'order.orderItems.menuItem'])
            ->orderBy('created_at', 'desc')
            ->get();
        return RatingResource::collection($ratings);

    }
    public function viewAllRestaurantReviews(ViewRatingsRequest $request)

    {


        $query = Rating::with(['user:id,first_name,last_name', 'restaurant:id,name'])

            ->orderBy('created_at', 'desc');


        $result = app(Pipeline::class)

            ->send($query)

            ->through([

                \App\Pipelines\Filters\RestaurantReviewsFilter\FilterReviewsByRestaurantName::class,

            ])

            ->thenReturn()

            ->get(); // Fetch all ratings as a collection

        $restaurants = Restaurant::select('id', 'name')->get();


        $totalRestaurants = $restaurants->count();


        return [

            'reviews' => $result,

            'restaurants' => $restaurants,

            'total_restaurants' => $totalRestaurants

        ];

    }
}
