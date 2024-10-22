<?php

namespace App\Pipelines\RestaurantReviewsFilter;

use Closure;

class FilterReviewsByRestaurantName
{
    public function handle($query, Closure $next)
    {
        if (request()->has('name')) {
            $query->whereHas('restaurant', function ($each) {
                $each->where('name', request('name')); // Filter by restaurant's name
            });
        }

        return $next($query);
    }
}
