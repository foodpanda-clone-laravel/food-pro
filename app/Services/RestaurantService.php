<?php

namespace App\Services;

use App\DTO\BranchDTO;
use App\DTO\RestaurantDTO;
use App\DTO\RestaurantOwnerDTO;
use App\DTO\UserDTO;
use App\Models\Restaurant;
use App\Models\RestaurantOwner;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Models\User;

class RestaurantService
{
    public function createRestaurantWithOwner(array $data)
    {
        DB::beginTransaction();
        
        try {
            // Create the User
            $userDTO = new UserDTO(
                first_name: $data['first_name'],
                last_name: $data['last_name'],
                email: $data['email'],
                password: $data['password'],
                phone_number:$data['phone_number']
            );
            $user = User::create($userDTO->toArray());

            // Create the Restaurant Owner
            $restaurantOwnerDTO = new RestaurantOwnerDTO(
                cnic: $data['cnic'],
                user_id: $user->id, 
                bank_name: $data['bank_name'],
                iban: $data['iban'],
                account_owner_title: $data['account_owner_title']
            );
            $owner = RestaurantOwner::create($restaurantOwnerDTO->toArray());

            // Create the Restaurant
            $restaurantDTO = new RestaurantDTO(
                name: $data['name'],
                owner_id: $owner->id, 
                opening_time: $data['opening_time'],
                closing_time: $data['closing_time'],
                cuisine: $data['cuisine'],
                business_type: $data['business_type'],
                logo_path: $data['logo_path']
            );
            $restaurant = Restaurant::create($restaurantDTO->toArray());

            // Create the Branch
            $branchDTO = new BranchDTO(
                address: $data['address'],
                postal_code: $data['postal_code'],
                city: $data['city'],
                restaurant_id: $restaurant->id 
            );
            $branch = Branch::create($branchDTO->toArray());

            // Commit the transaction if all queries are successful
            DB::commit();

            return [
                'Restaurant_Owner' => $owner,
                'restaurant' => $restaurant,
                'user' => $user,
                'branch' => $branch
            ];

        } catch (Exception $e) {
            // Rollback the transaction in case of error
            DB::rollBack();

            logger()->error('Error in creating restaurant and owner: ' . $e->getMessage(), [
                'data' => $data,
            ]);
            return ['error' => 'Failed to register restaurant and owner.'];
        }
    }
}
