<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\CategoryRepositoryInterface::class,
            \App\Repositories\CategoryRepository::class
        );

        $this->app->bind(
            \App\Interfaces\PlantRepositoryInterface::class,
            \App\Repositories\PlantRepository::class
        );

        $this->app->bind(
            \App\Interfaces\OrderRepositoryInterface::class,
            \App\Repositories\OrderRepository::class
        );

        $this->app->bind(
            \App\Interfaces\StatisticsRepositoryInterface::class,
            \App\Repositories\StatisticsRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
