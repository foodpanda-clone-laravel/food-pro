<?php

namespace App\Http\Controllers\Rating;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestaurantRequests\ViewRatingsRequest;
use App\Services\Rating\RatingService;
use Symfony\Component\HttpFoundation\Response;

class RatingsController extends Controller
{
    protected $ratingService;
    public function __construct(RatingService $ratingService){
        $this->ratingService = $ratingService;
    }
    public function viewMyRestaurantRating(){
        $result = $this->ratingService->viewMyRestaurantRating();
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'My Restaurant Rating', $result);
    }
    public function viewRestaurantReviews(ViewRatingsRequest $request){
        $result = $this->ratingService->viewAllRestaurantReviews($request);
        return Helpers::sendSuccessResponse(Response::HTTP_OK, 'reviews', $result);

    }
}
