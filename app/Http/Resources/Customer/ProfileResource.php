<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->user->id,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'phone_number' => $this->user->phone_number,
            'email' => $this->user->email,
            'email_verified_at' => $this->user->email_verified_at,
            'created_at' => $this->user->created_at,
            'updated_at' => $this->user->updated_at,
            'customer' => [
                'id' => $this->id,
                'user_id' => $this->user_id,
                'address' => $this->address,
                'delivery_address' => $this->delivery_address,
                'favorites' => $this->favorites,
                'payment_method' => $this->payment_method,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ]
        ];
    }
}
