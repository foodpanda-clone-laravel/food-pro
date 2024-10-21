<?php

namespace App\Pipelines;

use Illuminate\Pipeline\Pipeline;

class FilterPipeline
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
      'deal' => 'App\\Pipelines\\Filters\\Deal',
      'App\\Pipelines\\Filters\\ClosingTime',
      'App\\Pipelines\\Filters\\OpeningTime',
      'App\\Pipelines\\Filters\\Cuisine',
      'App\\Pipelines\\Filters\\Rating',
      'price_min' => 'App\\Pipelines\\Filters\\PriceRange',
      'price_max' => 'App\\Pipelines\\Filters\\PriceRange',
    ];

    return array_filter(array_map(function ($filter) use ($availableFilters) {
      return $availableFilters[$filter] ?? null;
    }, array_keys($filters)));
  }
}
