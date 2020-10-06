<?php

Route::get('coupon', 'Ricadesign\LaravelCoupon\CouponController@searchCoupon')->middleware(['web', 'throttle:60,1']);