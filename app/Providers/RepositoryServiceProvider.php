<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\CarRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CarRepositoryInterface::class, CarRepository::class);
    }
}