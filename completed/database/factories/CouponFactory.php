<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models;
use App\Models\Coupon;
use Faker\Generator as Faker;

$factory->define(Coupon::class, function (Faker $faker) {
    return [
        'code' => $faker->md5,
        'percent_off' => $faker->numberBetween(1, 100),
        'expired_at' => null,
    ];
});

$factory->state(Coupon::class, 'expired', [
    'expired_at' => now()
]);