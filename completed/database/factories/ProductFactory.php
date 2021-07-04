<?php
/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' => $faker->randomFloat(2, 1, 100),
        'ordinal' => $faker->randomDigitNotNull,
    ];
});

$factory->state(Product::class, 'starter', [
   'id' => Product::STARTER,
]);

$factory->state(Product::class, 'master', [
    'id' => Product::MASTER,
]);