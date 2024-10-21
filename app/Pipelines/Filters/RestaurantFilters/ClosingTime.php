<?php

namespace App\Pipelines\Filters\RestaurantFilters;

use Closure;

class ClosingTime
{
  public function handle($query, Closure $next)
  {
    // Apply the filter if the 'closing_time' exists in the request
    if (request()->has('closing_time')) {
      $query->where('closing_time', '<=', request('closing_time'));
    }

    return $next($query);
  }
}
