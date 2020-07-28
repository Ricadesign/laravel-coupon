<?php

Route::get('coupon', 'RicaDesign\LaravelCoupon\CouponController@searchCoupon')->middleware(['web', 'auth']);
