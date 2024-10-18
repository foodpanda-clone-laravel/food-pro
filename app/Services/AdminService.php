<?php

namespace App\Services;

use App\DTO\BranchDTO;
use App\DTO\RestaurantDTO;
use App\DTO\RestaurantOwnerDTO;
use App\DTO\UserDTO;
use App\Interfaces\AdminServiceInterface;
use App\Jobs\SendAcceptedRequestMailJob;
use App\Jobs\SendRejectedMailJob;
use App\Mail\AcceptedRequestMail;
use App\Mail\RejectRequestMail;
use App\Models\Orders\Order;
use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantRequest;
use App\Models\User\RestaurantOwner;
use App\Models\User\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Nette\Utils\Random;
use Spatie\Permission\Models\Role;

class AdminService implements AdminServiceInterface
{

    protected function assignRoleWithDirectPermissions($user, $roleName)
    {


        $role = Role::findByName($roleName);
        $user->assignRole($roleName);
        $permissions = $role->permissions->toArray();
        $permissionIds = array_column($permissions, 'id');
        $user->givePermissionTo($permissionIds);
        return $permissions;
    }
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
        $restaurants= Restaurant::all();
        return $restaurants;

    }
    public function updateRestaurantApplication(array $data,$request_id){

        $request = RestaurantRequest::findorfail($request_id);  

        $request->update($data);

        return $request;


    }

    public function approveRequest($request_id){ 

    // Find the student by ID
        $request = RestaurantRequest::findorfail($request_id);
      

        $data=$request->toArray();
        $data['password']=Random::generate(8);
        $temporarayPassword= $data['password'];
        

        DB::beginTransaction();
        

        try {

            if($request->status == 'approved'){
                throw new Exception('The restaurant is already approved.');
                
                
            }


            $request->update([
                'status' => 'approved',
            ]);

            $userDTO = new UserDTO($data);
            $user = User::create($userDTO->toArray());
            $permissions = $this->assignRoleWithDirectPermissions($user, 'Restaurant Owner');


            $data['user_id'] = $user->id;

            $restaurantOwnerDTO = new RestaurantOwnerDTO($data);
            $owner = RestaurantOwner::create($restaurantOwnerDTO->toArray());

            $data['owner_id'] = $owner->id;

            $restaurantDTO = new RestaurantDTO($data);
            $restaurant = Restaurant::create($restaurantDTO->toArray());

            $data['restaurant_id'] = $restaurant->id;

            $branchDTO = new BranchDTO($data);
            $branch = Branch::create($branchDTO->toArray());

            SendAcceptedRequestMailJob::dispatch($user->first_name, $temporarayPassword,  $restaurant->name, $user->email);
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

            dd($e);
        }
    }

    public function rejectRequest($request_id){

        try{
        $request = RestaurantRequest::findorfail($request_id);
        if(!$request->status == 'pending'){
            throw new Exception('The restaurant is already rejected or approved');
        }
        $request->update([
            'status' => 'declined',
        ]);

        SendRejectedMailJob::dispatch($request->email, $request->name);


        return $request;

    }catch (Exception $e){
        dd($e);
    }
}

public function viewAllOrders(){
    try{

        $query = DB::table('users as u')
        ->join('orders as o', 'u.id', '=', 'o.user_id')
        ->leftJoin('customers as c', 'u.id', '=', 'c.user_id')  // Use left join here
        ->select(
            'o.id',
            'u.first_name',
            'u.phone_number',
            'o.total_amount',
            'o.status',
            'o.created_at',
            'c.address as customer_address',  // Address can be null
            'u.id as user_id'
        )
        ->get();
    
    


        return $query;
    }

    catch (Exception $e){
        dd($e);
    }
}


public function viewOrderDetails($order_id){

    try{
        $order=Order::findorfail($order_id);
        return $order;

    }catch (Exception $e){
        dd($e);
    }
    

}


public function viewDeactivatedRestaurants()
{
    try {
        // Retrieve only soft-deleted restaurants
        $restaurants = Restaurant::onlyTrashed()->get();

        return response()->json($restaurants, 200);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to fetch deactivated restaurants.'], 500);
    }
}
}


