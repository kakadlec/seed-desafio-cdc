<?php

namespace App\Providers;

use App\Core\Infra\Contracts\CountryRepository;
use App\Core\Infra\Contracts\OrderRepository;
use App\Core\Infra\Contracts\StateRepository;
use App\Core\Infra\CountryRepositoryInDatabase;
use App\Core\Infra\OrderRepositoryInDatabase;
use App\Core\Infra\StateRepositoryInDatabase;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CountryRepository::class,
            CountryRepositoryInDatabase::class
        );
        $this->app->bind(
            StateRepository::class,
            StateRepositoryInDatabase::class
        );
        $this->app->bind(
            OrderRepository::class,
            OrderRepositoryInDatabase::class
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
