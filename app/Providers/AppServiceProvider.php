<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

		$this->app->bind(
			\App\Interfaces\BaseServiceInterface::class,
			\App\Services\BaseService::class
		);

		$this->app->bind(
			\App\Interfaces\Orders\OrderServiceInterface::class,
			\App\Services\Orders\OrderService::class
		);




		$this->app->bind(
			\App\Interfaces\Cart\CartServiceInterface::class,
			\App\Services\Cart\CartService::class
		);

		$this->app->bind(
			\App\Interfaces\BaseServiceInterface::class,
			\App\Services\BaseService::class
		);

		$this->app->bind(
			\App\Interfaces\Auth\RegisterServiceInterface::class,
			\App\Services\Auth\RegisterService::class
		);

		$this->app->bind(
			\App\Interfaces\Cart\ShoppingSessionServiceInterface::class,
			\App\Services\Cart\ShoppingSessionService::class
		);

		$this->app->bind(
			\App\Interfaces\ShoppingSessionServiceInterface::class,
			\App\Services\Cart\ShoppingSessionService::class,

			\App\Interfaces\menu\MenuServiceInterface::class,
			\App\Services\menu\MenuService::class
		);

		$this->app->bind(
			\App\Interfaces\Services\RestaurantService\RestaurantServiceInterface::class,
			\App\Services\Services\RestaurantService\RestaurantService::class
		);

		$this->app->bind(
			\App\Interfaces\RevenueServiceInterface::class,
			\App\Services\Revenue\RevenueService::class
		);

		$this->app->bind(
			\App\Interfaces\ChoiceGroupServiceInterface::class,
			\App\Services\Menu\ChoiceGroupService::class
		);

		$this->app->bind(
			\App\Interfaces\CartServiceInterface::class,
			\App\Services\Cart\CartService::class
		);

		$this->app->bind(
			\App\Interfaces\RevnueServiceInterface::class,
			\App\Services\Revenue\RevnueService::class
		);

		$this->app->bind(
			\App\Interfaces\CustomerProfileServiceInterface::class,
			\App\Services\CustomerProfileService::class
		);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
