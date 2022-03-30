<?php

Route::get('coupon', 'Ricadesign\LaravelCoupon\CouponController@searchCoupon')->middleware(['web', 'throttle:60,1']);
Route::post('coupon/', 'Ricadesign\LaravelCoupon\CouponController@redeem')->middleware(['web', 'throttle:60,1']);