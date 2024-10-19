<?php

namespace App\Services\Revenue;

use App\Helpers\Helpers;
use App\Interfaces\RevenueServiceInterface;
use App\Models\Orders\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RevenueService implements RevenueServiceInterface
{
    public function viewRestaurantsRevenue(){
        try{

        }
        catch(\Exception $e){
            dd($e);
        }
    }
    // restaurant owner dashboard
    public function viewMyRevenue(Request $request){
              /***
                * revenue: [6000, 7500, 8000, 9500],
                * orderVolume: [1000, 1200, 1100, 1300]
                 */
        try{
            $currentMonth = \Carbon\Carbon::now()->monthName;
            $user = Auth::user();
            $restaurant = $user->restaurantOwner->restaurant;
            // write base query
            // then group by daily weekly, monthly or weekly using pipes
            // default is monthly
            $orders = Order::where('restaurant_id', $restaurant->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->get()->toArray();
            $amount= array_column($orders, 'total_amount');
            $created_at = array_column($orders, 'created_at');
            // order received in a day or week or month
            $data = [
                'total_revenue'=>[
                    'revenue'=>$amount,
                    'created_at'=>$created_at,]
            ];
            $orderVolumes = DB::table('orders')
                ->select(DB::raw('DATE(created_at) as order_date'), DB::raw('COUNT(*) as order_count'))
                ->whereYear('created_at', Carbon::now()->year)
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('order_date')
                ->get()->toArray();
            $orderVolume = array_column($orderVolumes, 'order_count');
            $orderDate = array_column($orderVolumes, 'order_date');
            $data['order_volume']=[
                'order_date'=>$orderDate,
                'order_count'=>$orderVolume,
            ];
            return Helpers::sendSuccessResponse(200, 'revenue', $data);
        }
        catch(\Exception $e){
            dd($e);
        }
    }
}
