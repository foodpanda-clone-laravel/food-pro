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
           return  $user->restaurantOwner->restaurant;

        }
        catch (\Exception $exception){
            dd($exception);
            throw new \Exception("Restaurant not found");

        }
    }
}
