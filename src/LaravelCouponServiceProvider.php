<?php

namespace Ricadesign\LaravelCoupon;

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
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-coupon');

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
            __DIR__.'/../config/config.php' => config_path('laravel-coupon.php'),
        ]);
    }
}
