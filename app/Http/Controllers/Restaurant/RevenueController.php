<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Services\Revenue\RevenueService;


class RevenueController extends Controller
{
    // admin dashboard
    public function __construct(RevenueService $revenueService)
    {
        $this->revenueService = $revenueService;
    }

    public function viewRestaurantRevenues()
    {
        $result = $this->revenueService->viewRestaurantsRevenue();
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'revenue', $result);
    }

    // restaurant owner dashboard
    public function viewMyRevenue(Request $request)
    {

        $result = $this->revenueService->viewMyRevenue($request);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'my revenue', $result);
    }

}

