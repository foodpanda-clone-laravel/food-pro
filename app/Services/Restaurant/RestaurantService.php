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
use App\Models\Restaurant\RestaurantRequest;
use Exception;

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
//            $restaurant = $this->getRestaurantOwner()->withTrashed()->firstOrFail();
            $restaurant->restore();

            return $restaurant; // Return the restored restaurant details if needed
        } catch (\Exception $e) {
              dd($e);
            return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST, 'Could not restore restaurant');
        }
    }

    /**
     *
     * @param array $data
     * @return mixed
     */
    public function updateRestaurant( $data)
    {


        try {
            $user = Auth::user();
    
            // Find the restaurant request by user's email
            $restaurantRequest = RestaurantRequest::where('email', $user->email)->first();

        if ($restaurantRequest) {
            // Extract the validated data from the request object

            // Check if the request has 'first_name', 'last_name', or 'phone_number' and update the user model
            $userData = [];

            if (isset($data['first_name'])) {
                $userData['first_name'] = $data['first_name'];
            }

            if (isset($data['last_name'])) {
                $userData['last_name'] = $data['last_name'];
            }

            if (isset($data['phone_number'])) {
                $userData['phone_number'] = $data['phone_number'];
            }

            // Update user table if any of the fields are present
            if (!empty($userData)) {
                $user->update($userData);
            }

            // Remove 'contact' from the data before updating the restaurant request
            if (isset($data['phone_number'])) {
                unset($data['phone_number']);
            }

            // Update the restaurant request with the remaining validated data (excluding 'contact')
            $restaurantRequest->update($data);

            return $user;

        }} catch (\Exception $e) {
            // Handle the exception, log it, and return a meaningful response
            dd($e);
                        return false;
        }
    }

    public function showRestaurantDeatils(){

        try{
        $user=Auth::user();
        $restaurant_details= RestaurantRequest::where('email',$user->email)->first();
        return $restaurant_details;
        }
        catch(Exception $e){

            dd($e);
        }


    }
}
