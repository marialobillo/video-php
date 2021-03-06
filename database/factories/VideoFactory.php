<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

class VideoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Video::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(3, true),
            'heading' => $this->faker->sentence,
            'summary' => $this->faker->text,
            'vimeo_id' => $this->faker->randomNumber(),
            'ordinal' => $this->faker->randomNumber(),
            'lesson_id' => function() {
                return Lesson::factory()->create()->id;
            },
        ];
    }
}
