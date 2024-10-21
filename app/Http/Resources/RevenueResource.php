<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RevenueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $revenueDetails  = $this->revenue_details->toArray();

        $revenue = array_column($revenueDetails, 'total_amount');
        $createdAt = array_column($revenueDetails, 'created_at');
        $restaurantName = array_column($revenueDetails, 'restaurant_name');
        return [
            'revenue_details'=>[
                'revenue'=>$revenue,
                'created_at'=>$createdAt,
                'restaurant_name'=>$restaurantName,
            ],
            'order_volume_details'=>[
                                'order_date'=>$this->order_volume_details['order_date'],
                                'order_volume'=>$this->order_volume_details['order_volume'],
                                'restaurant_name'=>$this->order_volume_details['restaurant_name']
            ]
        ];
    }
}
