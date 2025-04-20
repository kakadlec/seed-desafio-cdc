<?php

namespace App\Providers;

use App\Core\Infra\CountryRepository;
use App\Core\Infra\CountryRepositoryInDatabase;
use App\Core\Infra\StateRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
