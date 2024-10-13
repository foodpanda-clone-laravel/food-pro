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
			\App\Interfaces\AddToCartServiceV2Interface::class,
			\App\Services\AddToCartServiceV2::class
		);

		$this->app->bind(
			\App\Interfaces\MenuServiceV2Interface::class,
			\App\Services\Menu\MenuServiceV2::class
		);

		$this->app->bind(
			\App\Interfaces\MenuBaseServiceInterface::class,
			\App\Services\Menu\MenuBaseService::class
		);

		$this->app->bind(
			\App\Interfaces\AddVariationGroupRequestInterface::class,
			\App\Services\AddVariationGroupRequest::class
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
