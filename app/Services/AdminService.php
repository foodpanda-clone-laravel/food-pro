<?php

namespace App\Services;

use App\DTO\BranchDTO;
use App\DTO\RestaurantDTO;
use App\DTO\RestaurantOwnerDTO;
use App\DTO\UserDTO;
use App\Interfaces\AdminServiceInterface;
use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantRequest;
use App\Models\User\RestaurantOwner;
use App\Models\User\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;

class AdminService implements AdminServiceInterface
{
    public function viewRestaurantRevenues(){

    }
    // filter restaurants by cuisine
    // restaurants with pending, rejected, deactivated
    public function viewRestaurantApplications(){


        try{
            $requests= RestaurantRequest::all();
            return $requests;
        }catch (Exception $e){
            dd($e);
         }


    }
    public function viewAllRestaurants(){

    }
    public function updateRestaurantApplication(){

    }

    public function approveRequest($request_id){ 

    // Find the student by ID
        $request = RestaurantRequest::findorfail($request_id);

        if ($request->status != 'pending') {
            throw new Exception('The student is already approved or rejected.');
        }

        $request->update([
            'status' => 'approved',
        ]);

        $data=$request->toArray();
        $data['password']=Random::generate(8);
        $temporarayPassword= $data['password'];

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
            DB::commit();

            return [
                'User' => $user,
                'password' => $temporarayPassword,
                'Restaurant_Owner' => $owner,
                'restaurant' => $restaurant,
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


        

       

        


}


