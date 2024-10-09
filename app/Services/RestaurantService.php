<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Models\RestaurantOwner;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;

class RestaurantService
{
    public function createRestaurantWithOwner(array $data)
    {
        try {
            // Begin transaction
            return DB::transaction(function () use ($data) {
                // Get the logged-in user's ID
                $userId = Auth::id();

                // Create the restaurant owner
                $owner = RestaurantOwner::create([
                    'cnic' => $data['cnic'],
                    'user_id' => $userId,
                    'bank_name' => $data['bank_name'],
                    'iban' => $data['iban'],
                    'account_owner_title' => $data['account_owner_title'],
                ]);

                // Create the restaurant
                $restaurant = Restaurant::create([
                    'name' => $data['name'],
                    'owner_id' => $owner->id,
                    'address' => $data['address'],
                    'postal_code' => $data['postal_code'],
                    'city' => $data['city'],
                    'opening_time' => $data['opening_time'],
                    'closing_time' => $data['closing_time'],
                    'cuisine' => $data['cuisine'],
                    'business_type' => $data['business_type'],
                    'logo_path' => $data['logo_path'],
                ]);

                return [
                    'owner' => $owner,
                    'restaurant' => $restaurant,
                    'user_id' => $userId
                ];
            });
        } catch (Exception $e) {
            // Log the exception and return a meaningful response
            logger()->error('Error in creating restaurant and owner: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to register restaurant and owner.'], 500);
        }
    }
}
