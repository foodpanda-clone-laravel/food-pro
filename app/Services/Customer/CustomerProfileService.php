<?php

namespace App\Services;

use App\Interfaces\CustomerProfileServiceInterface;
use App\DTO\User\CustomerDTO;
use App\Models\User\Customer;
use App\Models\User\User;

class CustomerProfileService implements CustomerProfileServiceInterface
{

  public function updateProfile($userId, $validatedData)
  {
    $user = User::findOrFail($userId);
    $user->update($validatedData);

    // If there are any customer-specific fields (like address)
    $customerFields = array_intersect_key($validatedData, array_flip(['address', 'delivery_address', 'payment_method']));

    if (!empty($customerFields)) {
      $customer = Customer::where('user_id', $userId)->firstOrFail();
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