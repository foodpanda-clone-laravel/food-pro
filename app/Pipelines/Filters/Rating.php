<?php

namespace App\Pipelines\Filters;

use Closure;

class Rating
{
  public function handle($query, Closure $next)
  {
    if (request()->has('rating')) {
      $rating = request('rating');

      $query->whereHas('ratings', function ($query) use ($rating) {
        $query->select('restaurant_id', \DB::raw('AVG(stars) as average_rating'))
          ->groupBy('restaurant_id')
          ->having('average_rating', '>=', $rating);
      });
    }

    return $next($query);
  }
}
