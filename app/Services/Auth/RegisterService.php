<?php

namespace App\Services\Auth;

use App\DTO\Restaurant\RestaurantRequestDTO;
use App\DTO\User\CustomerDTO;
use App\DTO\User\UserDTO;
use App\Interfaces\Auth\RegisterServiceInterface;
use App\Jobs\SendRequestReceivedMailJob;
use App\Models\Restaurant\RestaurantRequest;
use App\Models\User\Customer;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\Helpers;
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

public function submitRestaurantRequest($data){

    try {
        DB::beginTransaction();
        $imagePath = $data->logo_path->store('RestaurantLogos', 'public'); // Save file to 'storage/app/public/logos'
        $data['logo_path'] = $imagePath;
        $form = new RestaurantRequestDTO($data);
        $form = RestaurantRequest::create($form->toArray());

        SendRequestReceivedMailJob::dispatch($data['email'], $data['first_name']);
        DB::commit();
        return $form;
    } catch (\Exception $e) {
        DB::rollBack();
        Helpers::sendFailureResponse(Response::HTTP_INTERNAL_SERVER_ERROR,__FUNCTION__,$e);
    }



}


}
