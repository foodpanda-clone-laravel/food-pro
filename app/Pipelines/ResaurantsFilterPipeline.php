<?php

namespace App\Pipelines;

use Illuminate\Pipeline\Pipeline;

class ResaurantsFilterPipeline
{
  public static function apply($query, $filters)
  {
    return app(Pipeline::class)
      ->send($query)
      ->through(self::getFilters($filters))
      ->thenReturn();
  }

  protected static function getFilters($filters)
  {
    // Define available filter classes here
    $availableFilters = [
      'deal' => 'App\\Pipelines\\Filters\\ViewRestaurantsFilter\\Deal',
        'App\\Pipelines\\Filters\\ViewRestaurantsFilter\\ClosingTime',
        'App\\Pipelines\\Filters\\ViewRestaurantsFilter\\OpeningTime',
        'App\\Pipelines\\Filters\\ViewRestaurantsFilter\\Cuisine',
        'App\\Pipelines\\Filters\\ViewRestaurantsFilter\\Rating',
      'price_min' => 'App\\Pipelines\\Filters\\ViewRestaurantsFilter\\PriceRange',
      'price_max' => 'App\\Pipelines\\Filters\\ViewRestaurantsFilter\\PriceRange',
    ];

    return array_filter(array_map(function ($filter) use ($availableFilters) {
      return $availableFilters[$filter] ?? null;
    }, array_keys($filters)));
  }
}
