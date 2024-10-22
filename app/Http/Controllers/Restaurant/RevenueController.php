<?php

namespace App\Http\Controllers\Restaurant;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\Revenue\RevenueResource;
use App\Models\Orders\Order;
use App\Services\Revenue\RevenueService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    // admin dashboard
    public function __construct(RevenueService $revenueService){
        $this->revenueService = $revenueService;
    }
    public function viewRestaurantRevenues(){
        try{
// revenue colum of orders
            $ordersRevenue = Order::with('restaurant')
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->get()
            ->map(function ($order){
                return [
                    'total_amount'=>$order->total_amount,
                    'created_at'=>$order->created_at,
                    'restaurant_name'=>($order->restaurant->name)];
            });
// calculate order volumes
            $orderVolumes = Order::with('restaurant') // Eager load the restaurant relationship
            ->whereYear('created_at', now()->year)
                ->get()
                ->groupBy(function ($order) {
                    return $order->created_at->toDateString(); // Group by order date
                })
                ->flatMap(function ($orders) {
                    return $orders->groupBy('restaurant_id')->map(function ($restaurantOrders) {
                        return [
                            'restaurant_name' => $restaurantOrders->first()->restaurant->name,
                            'order_volume' => $restaurantOrders->count(),
                            'order_date' => $restaurantOrders->first()->created_at->toDateString(),
                        ];
                    });
                });

            $orderChartDetails = [
                'order_date' => $orderVolumes->pluck('order_date'), // Get order dates
                'order_volume' => $orderVolumes->pluck('order_volume'), // Get order volumes
                'restaurant_name' => $orderVolumes->pluck('restaurant_name'), // Get restaurant names
            ];
            $data=[
                'revenue_details'=>$ordersRevenue,
                'order_volume_details'=>$orderChartDetails
            ];
            return new RevenueResource((object)$data);
        }
        catch(\Exception $e){
            dd($e);
        }
    }
    // restaurant owner dashboard
    public function viewMyRevenue(Request $request){
        //        /***
        //         * revenue: [6000, 7500, 8000, 9500],
        //         *
        //         * orderVolume: [1000, 1200, 1100, 1300],
        //         *
        //         * topRestaurants: [15000, 14000, 13500, 12000]
        //         */


//        try{
//            $user = Auth::user();
//            $restaurant = $user->restaurantOwner->restaurant;
//
//            $orders = Order::where('restaurant_id', $restaurant->id)
//                ->whereMonth('created_at', now()->month)
//                ->whereYear('created_at', now()->year)
//                ->get()->toArray();
//            $amount= array_column($orders, 'total_amount');
//            $created_at = array_column($orders, 'created_at');
//            $data = [
//                'total_revenue'=>[
//                    'revenue'=>$amount,
//                    'created_at'=>$created_at,]
//            ];
//            $orderVolumes = DB::table('orders')
//                ->select(DB::raw('DATE(created_at) as order_date'), DB::raw('COUNT(*) as order_count'))
//                ->whereYear('created_at', Carbon::now()->year)
//                ->where('restaurant_id', $restaurant->id)
//                ->groupBy(DB::raw('DATE(created_at)'))
//                ->orderBy('order_date')
//                ->get()->toArray();
//            $orderVolume = array_column($orderVolumes, 'order_count');
//            $orderDate = array_column($orderVolumes, 'order_date');
//            $data['order_volume']=[
//                'order_date'=>$orderDate,
//                'order_count'=>$orderVolume,
//            ];
//            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'revenue', $data);
//        }
//        catch(\Exception $e){
//            dd($e);
//        }
//
        $result = $this->revenueService->viewMyRevenue($request);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'my revenue', $result);
    }
}
