<?php

namespace App\Http\Controllers\RestaurantOwner;

use App\Http\Requests\RegisterRestaurantWithOwnerRequest;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Helpers\Helpers;

class RestaurantController extends Controller
{
    protected $restaurantService;

    public function __construct(RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function registerRestaurantWithOwner(RegisterRestaurantWithOwnerRequest $request): JsonResponse
    {
        $result = $this->restaurantService->createRestaurantWithOwner($request->getValidatedData());

        if (isset($result['error'])) {
            return Helpers::sendFailureResponse(500, $result['error']);
        }

        if (!isset($result['Restaurant_Owner'], $result['restaurant'], $result['user'], $result['branch'])) {
            return Helpers::sendFailureResponse(500, 'Incomplete data returned. Please try again.');
        }

        return Helpers::sendSuccessResponse(201, 'Restaurant and owner registered successfully', [
            'restaurant_owner' => $result['Restaurant_Owner'],
            'restaurant' => $result['restaurant'],
            'user' => $result['user'],
            'branch' => $result['branch'],
        ]);
    }
}
