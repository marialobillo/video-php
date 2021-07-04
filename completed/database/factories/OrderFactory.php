<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'product_id' => function () {
            return factory(Product::class)->state('starter')->create()->id;
        },
        'transaction_id' => $faker->word,
        'coupon_id' => function () {
            return factory(Coupon::class)->create()->id;
        },
        'total' => $faker->randomFloat(2, 1, 100),
    ];
});
