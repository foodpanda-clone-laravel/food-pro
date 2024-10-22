<?php

namespace App\Services\Customer;

use App\Interfaces\CustomerProfileServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\DTO\User\CustomerDTO;
use App\Models\User\Customer;
use App\Models\User\User;

class CustomerProfileService implements CustomerProfileServiceInterface
{
    public function changePassword($data){
        try{
            $user = Auth::user();
            if (Hash::check($data->old_password, $user->password)) {
                $user->password = bcrypt($data->new_password);
                $user->save();
                return true;
            }
            else{
                return false;
            }
        }
        catch(\Exception $e){
            dd($e);
        }
    }

  public function updateProfile($validatedData)
  {
    $user = Auth::user();
    $user->update($validatedData);

    // If there are any customer-specific fields (like address)
    $customerFields = array_intersect_key($validatedData, array_flip(['address', 'delivery_address', 'payment_method']));

    if (!empty($customerFields)) {
      $customer = $user->customer;
      $customer->update($customerFields);
    }
  }

  public function updateCustomerInfo($customerId, CustomerDTO $customerDTO)
  {
    $customer = Customer::findOrFail($customerId);

    if ($customerDTO->address) {
      $customer->address = $customerDTO->address;
    }
    if ($customerDTO->delivery_address) {
      $customer->delivery_address = $customerDTO->delivery_address;
    }
    if ($customerDTO->favorites !== null) {
      $customer->favorites = is_array($customerDTO->favorites) ? implode(',', $customerDTO->favorites) : $customerDTO->favorites;
    }

    $customer->save();
  }


  public function getProfile($userId)
  {
    return Customer::with('user:id,first_name,last_name,phone_number,email,email_verified_at,created_at,updated_at')
      ->where('user_id', $userId)
      ->firstOrFail();
  }

}
