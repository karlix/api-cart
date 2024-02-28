<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use src\Cart\Domain\Contracts\CartRepositoryContract;
use src\Cart\Infrastructure\Repositories\EloquentCartRepository;
use src\Cart\Infrastructure\CartService;
use src\Order\Domain\Contracts\OrderRepositoryContract;
use src\Order\Infrastructure\Repositories\EloquentOrderRepository;
use src\Product\Domain\Contracts\ProductRepositoryContract;
use src\Product\Infrastructure\Repositories\EloquentProductRepository;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryContract::class, EloquentProductRepository::class);
        $this->app->bind(CartRepositoryContract::class, EloquentCartRepository::class);
        $this->app->bind(OrderRepositoryContract::class, EloquentOrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
