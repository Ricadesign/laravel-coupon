<?php

namespace RicaDesign\LaravelCoupon;

use Illuminate\Support\ServiceProvider;

class LaravelCouponServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Ricadesign\LaravelCoupon\CouponController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->publishes([
            __DIR__.'/migrations' => database_path('migrations'),
        ]);
    }
}
