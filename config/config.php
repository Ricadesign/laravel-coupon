<?php

return [
  'unique_email' => env('LARAVEL_COUPON_UNIQUE_EMAIL', false),
  'coupon_for_product' => env('LARAVEL_COUPON_COUPON_FOR_PRODUCT', false),
  'min_type' => env('LARAVEL_COUPON_MIN_TYPE', false),
  'open_refund' => env('LARAVEL_COUPON_OPEN_REFUND', false)
];