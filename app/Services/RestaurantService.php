<?php

namespace App\Services;

use App\DTO\BranchDTO;
use App\DTO\RestaurantDTO;
use App\DTO\RestaurantOwnerDTO;
use App\DTO\UserDTO;
use App\Models\Orders\Order;
use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Rating;
use App\Models\Restaurant\Restaurant;
use App\Models\User\RestaurantOwner;
use App\Models\User\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RestaurantService
{
    public function createRestaurantWithOwner(array $data)
    {
        DB::beginTransaction();

        try {
            $userDTO = new UserDTO($data);
            $user = User::create($userDTO->toArray());

            $restaurantOwnerDTO = new RestaurantOwnerDTO($data);
            $owner = RestaurantOwner::create($restaurantOwnerDTO->toArray());

            $restaurantDTO = new RestaurantDTO($data);
            $restaurant = Restaurant::create($restaurantDTO->toArray());

            $branchDTO = new BranchDTO($data);
            $branch = Branch::create($branchDTO->toArray());
            dd($branch);
            DB::commit();

            return [
                'Restaurant_Owner' => $owner,
                'restaurant' => $restaurant,
                'user' => $user,
                'branch' => $branch
            ];

        } catch (Exception $e) {
            DB::rollBack();

            logger()->error('Error in creating restaurant and owner: ' . $e->getMessage(), [
                'data' => $data,
            ]);
            return ['error' => 'Failed to register restaurant and owner.'];
        }
    }
    // get the restaurant id from order details
    public function viewMyRestaurantRating(){
        $user = Auth::user();
        $restaurant = $user->restaurantOwner->restaurant;
    // get all the orders from the restaurant inner join on ratings table
        $ratings = Rating::where('restaurant_id', $restaurant->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return $ratings;
    }
}
