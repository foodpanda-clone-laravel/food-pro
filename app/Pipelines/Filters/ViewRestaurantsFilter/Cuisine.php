<?php

namespace App\Pipelines\Filters\ViewRestaurantsFilter;

use Closure;

class Cuisine
{
  public function handle($query, Closure $next)
  {
    if (request()->has('cuisine')) {
      $query->whereRaw('LOWER(cuisine) = ?', [strtolower(request('cuisine'))]);
    }

    return $next($query);
  }
}
