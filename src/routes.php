<?php

Route::get('coupon', 'Ricadesign\LaravelCoupon\CouponController@searchCoupon')->middleware(['web', 'auth']);
