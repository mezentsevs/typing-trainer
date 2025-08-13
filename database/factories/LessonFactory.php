<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'number' => $number = $this->faker->numberBetween(1, 20),
            'total' => $this->faker->numberBetween($number, 20),
            'language' => $this->faker->randomElement(['en', 'ru']),
            'new_chars' => $this->faker->regexify('[a-z]{5}'),
            'text' => $this->faker->sentence(10, true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
