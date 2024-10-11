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

    // Register restaurant and owner together
    public function registerRestaurantWithOwner(RegisterRestaurantWithOwnerRequest $request): JsonResponse
    {
        // Call the service to create restaurant and owner
        $result = $this->restaurantService->createRestaurantWithOwner($request->getValidatedData());

        // Check if there was an error in the result
        if (isset($result['error'])) {
            return Helpers::sendFailureResponse(500, $result['error']);
        }

        // Ensure the required keys are present in the result array
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
