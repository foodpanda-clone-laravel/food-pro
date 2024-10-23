<?php

namespace App\DTO\Customer;

use App\DTO\BaseDTO;
use Illuminate\Support\Facades\Auth;

class FavoritesDTO extends BaseDTO
{
    public function __construct($request)
    {
        $user = Auth::user();

        $this->customer_id = $user->customer->id;
        $this->restaurant_id = $request->restaurant_id;
    }
}
