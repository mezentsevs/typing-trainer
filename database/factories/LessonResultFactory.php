<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\LessonResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LessonResult>
 */
class LessonResultFactory extends Factory
{
    protected $model = LessonResult::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'lesson_id' => Lesson::factory(),
            'language' => $this->faker->randomElement(['en', 'ru']),
            'time_seconds' => $this->faker->numberBetween(1, 600),
            'speed_wpm' => $this->faker->numberBetween(1, 100),
            'errors' => $this->faker->numberBetween(0, 10),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
