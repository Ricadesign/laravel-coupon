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
        $this->app->make('RicaDesign\LaravelCoupon\CouponController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        // $this->publishes([
        //     __DIR__.'/Coupon.php' => app_path()
        // ]);
    }
}
