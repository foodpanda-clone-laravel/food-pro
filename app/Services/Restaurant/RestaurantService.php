<?php

namespace App\Services\Restaurant;

use Illuminate\Support\Facades\DB;
use App\Helpers\Helpers;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Restaurant\Branch;
use Illuminate\Support\Facades\Auth;
use App\Models\User\RestaurantOwner;
use App\Models\Restaurant\Restaurant;

class RestaurantService
{
    public function getRestaurantOwner()
    {
        $user = Auth::user();

        // Find the restaurant owner
        $owner = RestaurantOwner::where('user_id', $user->id)->firstOrFail();

        // Find the restaurant associated with the owner
        $restaurant = Restaurant::where('owner_id', $owner->id)->firstOrFail();

        return $restaurant;
    }

    // public function getRestaurantWithDetails()
    // {
    //     try {
    //         $restaurant = $this->getRestaurantOwner();

    //         $menus = Menu::where("restaurant_id", $restaurant->id)->get();

    //         $allMenuItems = [];

    //         foreach ($menus as $menu) {
    //             $menuItems = MenuItem::where("menu_id", $menu->id)->get();

    //             $allMenuItems[] = [
    //                 'menu_id' => $menu->id,
    //                 'menu_name' => $menu->name,
    //                 'items' => $menuItems
    //             ];
    //         }

    //         return Helpers::sendSuccessResponse(200, 'Restaurant details', [
    //             'restaurant_name' => $restaurant->name,
    //             'restaurant_id' => $restaurant->id,
    //             'menus' => $allMenuItems
    //         ]);

    //     } catch (\Exception $e) {
    //         Helpers::createErrorLogs($e, request()->id);
    //         return Helpers::sendFailureResponse(500, 'Failed to retrieve restaurant details');
    //     }
    // }

    /**
     * Soft delete the restaurant owned by the logged-in user
     *
     * @return mixed
     */
    public function softDeleteRestaurant()
    {
        try {
            $restaurant = $this->getRestaurantOwner();
             $restaurant->delete();
            return true;
        } catch (\Exception $e) {
           dd($e);
        }
    }
    public function restoreRestaurant()
    {
        try {

            $restaurant=$this->getRestaurantOwner();
            $restaurant = $this->getRestaurantOwner()->withTrashed()->firstOrFail();
            $restaurant->restore();

            return $restaurant; // Return the restored restaurant details if needed
        } catch (\Exception $e) {
              dd($e);
            return Helpers::sendFailureResponse(400, 'Could not restore restaurant');
        }
    }

    /**
     *
     * @param array $data
     * @return mixed
     */
    public function updateRestaurant(array $data)
    {


        try {

            $restaurant = $this->getRestaurantOwner();
            $branch= Branch::where('restaurant_id',$restaurant->id)->first();

            $restaurant->update([
                'name' => $data['restaurant_name'] ?? $restaurant->name,
                'opening_time' => $data['opening_time'] ?? $restaurant->opening_time,
                'closing_time' => $data['closing_time'] ?? $restaurant->closing_time,
                'logo_path' => $data['logo_path'] ?? $restaurant->logo_path,
            ]);

            if (isset($data['address'])) {

                $branch->update([
                    'address' => $data['address'],
                ]);

            }

            return Helpers::sendSuccessResponse(200, 'Restaurant successfully updated');
        } catch (\Exception $e) {
            return Helpers::sendFailureResponse(400, 'Could not update restaurant');
        }
    }
}
