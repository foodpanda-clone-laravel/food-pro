<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRestaurantWithOwnerRequest;
use App\Services\RestaurantService;
use Illuminate\Http\JsonResponse;

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

        $result = $this->restaurantService->createRestaurantWithOwner($request->validated());

        return response()->json([
            'message' => 'Restaurant and owner registered successfully',
            'owner' => $result['owner'],
            'restaurant' => $result['restaurant'],
            'user_id' => $result['user_id'],
        ], 201);
    }
}
