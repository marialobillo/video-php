<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Video;
use App\Models\Lesson;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'heading' => $faker->sentence,
        'summary' => $faker->text,
        'vimeo_id' => $faker->md5,
        'ordinal' => $faker->randomDigitNotNull,
        'lesson_id' => function () {
            return factory(Lesson::class)->create()->id;
        },
    ];
});
