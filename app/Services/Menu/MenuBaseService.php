<?php

namespace App\Services\Menu;

use App\Interfaces\MenuBaseServiceInterface;
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
        }
    }
}
