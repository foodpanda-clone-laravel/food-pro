<?php

namespace App\Http\Requests\OrderRequests;


use App\Http\Requests\BaseRequest;

class ViewOrderDetailsRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $orderId = $this->route('order_id');
        return [
           'order_id'=>'required|exists:orders,id'
        ];
    }
    protected function prepareForValidation()
    {
        // Merge the route parameter 'order' as 'order_id' in the request data
        $this->merge([
            'order_id' => $this->route('order'),
        ]);
    }
}
