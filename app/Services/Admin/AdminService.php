<?php

namespace App\Services\Admin;

use App\DTO\Restaurant\BranchDTO;
use App\DTO\Restaurant\RestaurantDTO;
use App\DTO\User\RestaurantOwnerDTO;
use App\DTO\User\UserDTO;
use App\Helpers\Helpers;
use App\Interfaces\AdminServiceInterface;
use App\Jobs\SendAcceptedRequestMailJob;
use App\Jobs\SendRejectedMailJob;
use App\Mail\RejectRequestMail;
use App\Models\Orders\Order;
use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantRequest;
use App\Models\User\RestaurantOwner;
use App\Models\User\User;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
    public function viewRestaurantApplications(){
        try{
            $requests= RestaurantRequest::all();
            return [
                'header_code' => Response::HTTP_OK,
                'message'=> 'All Restaurants',
                'body' => $requests
            ];
        }catch (Exception $e){
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

              }


    }
    public function viewAllRestaurants(){
        try{
            $restaurants= Restaurant::all();
            return [
                'header_code' => Response::HTTP_OK,
                'message'=> 'All Restaurants',
                'body' => $restaurants
            ];
                }
            catch (Exception $e){

            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);
        }

    }
    public function updateRestaurantApplication(array $data,$request_id){

        try{

        $request = RestaurantRequest::findorfail($request_id);

        $request->update($data);

        return [
            'header_code' => Response::HTTP_OK,
            'message'=> 'All Restaurants',
            'body' => $request
        ];
            }
        catch (Exception $e){

        return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);
    }


    }

    public function approveRequest($request_id){



        try {
            $request = RestaurantRequest::findorfail($request_id);

            $data=$request->toArray();
            $data['password']=Random::generate(8);
            $temporarayPassword= $data['password'];


            DB::beginTransaction();

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
                'header_code' => Response::HTTP_OK,
                'message' => 'Accepted Restaurant',
                'body' => [
                    'restaurants' => $restaurant,
                    'user' => $user,
                    'temporary_password' => $temporarayPassword,
                    'restaurant_owner' => $owner,
                    'restaurant' => $restaurant,
                    'branch' => $branch,
                ],
            ];

        } catch (Exception $e) {
            DB::rollBack();
            return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);


        }
    }

    public function rejectRequest($request_id){

        try{
        $request = RestaurantRequest::findorfail($request_id);

        if ($request->status !== 'pending') {
            throw new Exception('The restaurant is already rejected.');
        }
        $request->update([
            'status' => 'declined',
        ]);

        SendRejectedMailJob::dispatch($request->email, $request->name);


        return [
            'header_code' => Response::HTTP_OK,
            'message'=> 'Rejected Restaurant',
            'body' => $request
        ];

    }catch (Exception $e){

        return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);
    }
}

public function viewAllOrders(){
    try{
        $query = DB::table('users as u')
        ->join('orders as o', 'u.id', '=', 'o.user_id')
        ->join('restaurants as r', 'r.id', '=', 'o.restaurant_id')
        ->leftJoin('customers as c', 'u.id', '=', 'c.user_id')  // Use left join here
        ->select(
            'o.id',
            'r.name as restaurant_name',
            'u.first_name',
            'u.phone_number',
            'o.total_amount',
            'o.status',
            'o.created_at',
            'c.address as customer_address',  // Address can be null
            'u.id as user_id'
        )
        ->get();

        return [
            'header_code' => Response::HTTP_OK,
            'message'=> 'All Orders',
            'body' => $query
        ];

    }

    catch (Exception $e){
        return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

    }
}


public function viewOrderDetails($order_id){

    try{
        $order=Order::findorfail($order_id);
        return [
            'header_code' => Response::HTTP_OK,
            'message'=> 'Order with its details',
            'body' => $order
        ];
     }
     catch (Exception $e){

        return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);
    }


}


public function viewDeactivatedRestaurants()
{
    try {
        // Retrieve only soft-deleted restaurants
        $restaurants = Restaurant::onlyTrashed()->get();

        return [
            'header_code' => Response::HTTP_OK,
            'message'=> 'Deactivated Restaurants',
            'body' => $restaurants
        ];

    }

    catch (Exception $e){
        return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

    }
}
public function activateRestaurant($restaurant_id){
    try{
        $restaurant = Restaurant::onlyTrashed()->findorfail($restaurant_id);
        $restaurant->restore();
        return [
            'header_code' => Response::HTTP_OK,
            'message'=> 'Activated Restaurant',
            'body' => $restaurant
        ];

    }

    catch (Exception $e){
        return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

    }
}

public function deactivateRestaurant($restaurant_id){
    try{
        $restaurant = Restaurant::findorfail($restaurant_id);
        $restaurant->delete();
        return [
            'header_code' => Response::HTTP_OK,
            'message'=> 'Deactivated Restaurant',
            'body' => $restaurant
        ];

    }

    catch (Exception $e){
        return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);

    }
}

public function showRestaurants(){
    try{
        $results = Restaurant::join('branches as b', 'restaurants.id', '=', 'b.restaurant_id')
        ->leftJoin('ratings as ra', 'restaurants.id', '=', 'ra.restaurant_id')
        ->select(
            'restaurants.logo_path',
            'restaurants.name',
            'b.delivery_time',
            DB::raw('ROUND(AVG(ra.stars), 1) as avg_rating'),
            DB::raw('COUNT(ra.id) as review_count')
        )
        ->groupBy('restaurants.id', 'restaurants.name', 'b.delivery_time', 'restaurants.logo_path')
        ->get();
        return [
            'header_code' => Response::HTTP_OK,
            'message'=> 'All Restaurants',
            'body' => $results
        ];
    }catch (Exception $e){
        return Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR , __FUNCTION__,$e);
    }
}
}
