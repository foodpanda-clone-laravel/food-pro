<?php

namespace App\Pipelines\Filters\RestaurantFilters;

use Closure;

class PriceRange
{
  public function handle($query, Closure $next)
  {
    if (request()->has('price_min') || request()->has('price_max')) {
      $priceMin = request('price_min', 0);
      $priceMax = request('price_max', PHP_INT_MAX);

      $query->whereHas('menus.menuItems', function ($q) use ($priceMin, $priceMax) {
        $q->whereBetween('price', [$priceMin, $priceMax]);
      });
    }

    return $next($query);
  }
}
