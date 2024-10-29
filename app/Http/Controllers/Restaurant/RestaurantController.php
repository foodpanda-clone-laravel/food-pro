<?php

namespace App\Http\Controllers\Restaurant;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequests\UpdateRestaurantRequest;
use App\Services\Restaurant\RestaurantService;
use Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller
{
    protected $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function deleteRestaurant()
{
    try {
        $this->restaurantService->softDeleteRestaurant();

        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant deleted successfully');
    } catch (\Exception $e) {
        return Helpers::sendFailureResponse(Response::HTTP_BAD_REQUEST);
    }
}

    public function restoreRestaurant()
    {
            $result = $this->restaurantService->restoreRestaurant();

            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant restored successfully', $result);

    }


    public function updateRestaurant(UpdateRestaurantRequest $request)
    {

             $result=$this->restaurantService->updateRestaurant($request);
            return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Restaurant updated successfully',$result);

    }
    public function showRestaurantDeatils(){

        $result = $this->restaurantService->showRestaurantDeatils();
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'Details of owner', $result);
    }
}


