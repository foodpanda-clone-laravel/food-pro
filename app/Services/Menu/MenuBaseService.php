<?php

namespace App\Services\Menu;

use App\Interfaces\MenuBaseServiceInterface;
use App\Models\Restaurant;
use App\Models\RestaurantOwner;
use Illuminate\Support\Facades\Auth;

class MenuBaseService implements MenuBaseServiceInterface
{
    public static function getRestaurant(){
        try{

            $user = Auth::user();
            $owner = RestaurantOwner::where('user_id', $user->id)->firstOrFail();
            return  Restaurant::where('owner_id', $owner->id)->firstOrFail();
        }
        catch (\Exception $exception){
            throw new \Exception("Restaurant not found");

        }
    }
}
