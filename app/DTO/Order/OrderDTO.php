<?php

namespace App\DTO\Order;

use App\DTO\BaseDTO;
use Illuminate\Support\Facades\Auth;

class OrderDTO extends BaseDTO
{

    public function __construct($data, $address) {
        $this->user_id = Auth::user()->id;
        $this->restaurant_id = $data->restaurant->id;
        $this->branch_id =$data->restaurant->branches->first()->id;
        $this->total_amount = $data->total;
        $this->status = 'in_progress';
        $this->order_type = 'delivery';
        $this->delivery_charges = $data->restaurant->branches->first()->delivery_fee;
        $this->estimated_delivery_time = now()->addMinutes(15);
        $this->delivery_address = $address['delivery_address'];
    }
}
