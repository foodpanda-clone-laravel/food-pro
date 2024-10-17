<?php

namespace App\Services\Auth;

use App\DTO\BranchDTO;
use App\DTO\CustomerDTO;
use App\DTO\RestaurantDTO;
use App\DTO\RestaurantOwnerDTO;
use App\DTO\RestaurantRequestDTO;
use App\DTO\UserDTO;
use App\Interfaces\Auth\RegisterServiceInterface;
use App\Models\Restaurant\Branch;
use App\Models\Restaurant\Restaurant;
use App\Models\Restaurant\RestaurantRequest;
use App\Models\User\Customer;
use App\Models\User\RestaurantOwner;
use App\Models\User\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;


class RegisterService implements RegisterServiceInterface
{
// here wer are creating user two times instead of repeating code we can create a protected function
    protected function assignRoleWithDirectPermissions($user, $roleName)
    {

        $role = Role::findByName($roleName);
        $user->assignRole($roleName);
        $permissions = $role->permissions->toArray();
        $permissionIds = array_column($permissions, 'id');
        $user->givePermissionTo($permissionIds);
        return $permissions;
    }
    protected function createUser($userDTO)
    {
        $user = User::create($userDTO->toArray());
        return $user;
    }

    public function createRestaurantWithOwner(array $data)
    {
        try {
            DB::beginTransaction();
            $userDTO = new UserDTO($data);
            $user = User::create($userDTO->toArray());
            $permissions = $this->assignRoleWithDirectPermissions($user, 'Restaurant Owner');
            $data['user_id']= $user->id;
            $restaurantOwnerDTO = new RestaurantOwnerDTO($data);
            $owner = RestaurantOwner::create($restaurantOwnerDTO->toArray());
            $data['owner_id'] = $owner->id;
            $logoPath = $data['logo_path']->store('logos', 'public'); // Save file to 'storage/app/public/logos'
            $data['logo_path'] = $logoPath;

            $restaurantDTO = new RestaurantDTO($data);
            $restaurant = Restaurant::create($restaurantDTO->toArray());
            $data['restaurant_id'] = $restaurant->id;
            // Create the Branch

            $branchDTO = new BranchDTO($data);
            $branch = Branch::create($branchDTO->toArray());

            // Commit the transaction if all queries are successful
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();

            logger()->error('Error in creating restaurant and owner: ' . $e->getMessage(), [
                'data' => $data,
            ]);
            return false;
        }
        return [
            'Restaurant_Owner' => $owner,
            'restaurant' => $restaurant,
            'user' => $user,
            'branch' => $branch,
        ];
    }
    protected function createCustomer($data)
    {
        $customerDTO = new CustomerDTO($data);
        return Customer::create($customerDTO->toArray());
    }
    public function register($data)
{
    try {
        DB::beginTransaction();

        $user = $this->createUser(new UserDTO($data));
        $this->assignRoleWithDirectPermissions($user, 'Customer');

        $data['user_id'] = $user->id;
        $this->createCustomer($data);

        DB::commit();

        return $user;
    } catch (\Exception $e) {
        DB::rollBack();
        dd($e);
        Log::error('Registration failed: ' . $e->getMessage());
        return false;
    }
}

public function submitRestaurantRequest(array $data){

    try {
        $form = new RestaurantRequestDTO($data);
        $form = RestaurantRequest::create($form->toArray());
    
        return $form;
    } catch (\Exception $e) {

       return $e;
    }



}


}
