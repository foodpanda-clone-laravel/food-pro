<?php

namespace App\Http\Controllers;

use App\Http\Requests\ViewRatingsRequest;
use App\Models\Restaurant\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    public function viewMyRestaurantRating(){
        $user = Auth::user();
        $restaurant = $user->restaurantOwner->restaurant;
        // get all the orders from the restaurant inner join on ratings table
        $ratings = Rating::select('ratings.*', 'users.first_name', 'users.last_name', 'orders.id as order_id','orders.total_amount as total_amount', 'menu_items.id as menu_item_id',
        'menu_items.image_file as menu_item_logo_path')

            ->join('users', 'ratings.user_id', '=', 'users.id')
            ->join('orders', 'ratings.order_id', '=', 'orders.id')
            ->join('order_items','orders.id','=','order_items.order_id')
            ->join('menu_items', 'order_items.menu_item_id','=','menu_items.id')
            ->where('ratings.restaurant_id', $restaurant->id)
            ->orderBy('ratings.created_at', 'desc')
            ->get()->toJson();
        return $ratings;
    }
    public function viewRestaurantReviews(ViewRatingsRequest $request){
        $data = $request->getValidatedData();
        $ratings = Rating::select(
            'ratings.*', // Select all columns from ratings table
            'users.first_name',
            'users.last_name'
        )
            ->join('users', 'ratings.user_id', '=', 'users.id')
            ->where('restaurant_id', $data['id'])
            ->orderBy('ratings.created_at', 'desc')
            ->get();
        return $ratings;
    }
}
