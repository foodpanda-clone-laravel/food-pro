<?php

namespace App\Pipelines\Filters\ViewRestaurantsFilter;

use Closure;

class BusinessType
{
  public function handle($query, Closure $next)
  {
    if (request()->has('business_type')) {
      $query->where('business_type', request('business_type'));
    }

    return $next($query);
  }
}
