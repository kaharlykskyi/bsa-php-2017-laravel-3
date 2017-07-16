<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16.07.17
 * Time: 19:48
 */

namespace App\Providers;


use App\Repositories\CarRepository;
use Illuminate\Support\ServiceProvider,
    App\Repositories\Contracts\CarRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->app->singleton(CarRepositoryInterface::class, CarRepository::class);
    }

}