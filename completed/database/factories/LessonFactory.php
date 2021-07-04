<?php
/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'name' => $faker->words(2, true),
        'ordinal' => $faker->randomDigitNotNull,
        'product_id' => null,
    ];
});