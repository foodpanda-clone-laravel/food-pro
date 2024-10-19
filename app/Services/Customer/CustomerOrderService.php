<?php

namespace App\Services\Customer;

use App\DTO\Order\OrderDTO;
use App\DTO\Order\OrderItemDTO;
use App\Interfaces\CustomerOrderServiceInterface;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Restaurant\Branch;
use App\Services\Cart\AddToCartServiceV2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerOrderService extends CustomerService implements CustomerOrderServiceInterface
{
    protected $cartService;
    protected $customer;
    public function __construct(AddToCartServiceV2 $addToCartServiceV2){
        $user = Auth::user();
        $this->customer = $user->customer;
        $this->cartService = $addToCartServiceV2;
    }
    public function checkout()
    {
        $itemsTotal = $this->cartService->calculateItemsTotal();
        $total = $this->cartService->calculateCartTotal();
        // get restaurant for the order

        $restaurant = DB::table('cart_items')
            ->select('restaurants.id','restaurants.name')
            ->join('restaurants','cart_items.restaurant_id','=','restaurants.id')
            ->groupBy('restaurant_id')->first();
        // as for now we have only one branch so we are searching for branch with given restaurant id
        $branch= Branch::where('restaurant_id', $restaurant->id)->first();
        $data['order_details']=[
            'items'=>json_decode($itemsTotal, true),
            'total'=>$total,
        ];
        $data['restaurant_details']=
            [
                'id'=>$restaurant->id,
                'name'=>$restaurant->name,
                'branch_id'=>$branch->id,
            ];
        $data['delivery_details']=[
            'delivery_fee'=>$branch->delivery_fee,
            'delivery_options'=>$branch->delivery_options
        ];
        $data['payment_method']=$this->customer->payment_method;
        $user = Auth::user();
        $data['customer_details']=[
            'name'=>$user->first_name.' '.$user->last_name,
            'email'=>$user->email,
            'phone_number'=>$user->phone_number,
            'delivery_address'=>$this->customer->delivery_address,
        ];
        return $data;
    }
    public function createOrder($address){
        try{
            DB::beginTransaction();
            $orderSummary = $this->checkout();
            $data['user_id']=Auth::user()->id;
            $data['restaurant_id']=$orderSummary['restaurant_details']['id'];
            $data['branch_id']=$orderSummary['restaurant_details']['branch_id'];
            $data['total_amount']=$orderSummary['order_details']['total'];
            $data['delivery_charges']=$orderSummary['delivery_details']['delivery_fee'];
            $data['delivery_address']=$address['delivery_address'];
            $orderDTO = new OrderDTO($data);
            $order = Order::create($orderDTO->toArray());
            $orderItems = $orderSummary['order_details']['items'];
            $orderItems = json_decode(json_encode($orderItems),true);
            $orderedItems = [];
        foreach($orderItems as $orderItem){
            $orderItem['id']=$order->id;
            $orderItemDTO = new OrderItemDTO($orderItem);
            $orderItem = OrderItem::create($orderItemDTO->toArray());
            $orderedItems[] = $orderItem;
        }
        // fix total price null

//            $paymentDTO = make payment table
        Db::commit();
        return $orderedItems;
        }
        catch(\Exception $e){
            dd($e);
            DB::rollBack();
            return false;
        }

    }
}
