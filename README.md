# Laravel Coupon

This composer package offers a setup to redeem coupon codes on ecommerce sites. It enables the use of several types of discounts, while offering the possibility of limiting user redemption by different means.

## Installation

Begin by pulling in the package through Composer.

```bash
composer require ricadesign/laravel-coupon
```

Next, if using Laravel 5, include the service provider within your `config/app.php` file. From version 5.5 and thanks to [package autodiscovery](https://laravel-news.com/package-auto-discovery) this is no longer necesary.

```php
'providers' => [
    Ricadesign\LaravelCoupon\LaravelCouponServiceProvider::class,
];
```

## Publishing migrations

In order for the package to work, the migrations included need to be published with the following command:

```bash
php artisan vendor:publish
```

Then you can run them with:

```bash
php artisan migrate
```

## Usage

Once installed a registered user will be able to send a GET petition to **/coupon?discount={COUPON_CODE}**. Either a valid coupon or a 404 error response will be returned.

The RicaDesign\LaravelCoupon\Coupon model also provides the following methods:

| Method | Params | Returns | Description |
| --- | --- | --- | --- |
| static findAndValidate | couponCode, subtotal, itemsCount | A valid coupon model or null |
| getDiscount | subtotal | Amount to be subtracted from subtotal (positive) |
| use | userId | void | Increments times_used field, adds entry to user_coupon table (if needed) |


## Coupon properties
| Property | Description 
| --- | --- | 
| value_discount | Value to discount in coupon type  FixPrice |
