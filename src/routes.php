<?php

Route::get('coupon', 'Ricadesign\LaravelCoupon\CouponController@searchCoupon')->middleware(['web', 'auth']);

Route::group(['prefix' => 'api', 'middleware' => 'api'], function() {
    Route::get('coupon', 'Ricadesign\LaravelCoupon\CouponController@searchCoupon');
});