<?php

namespace Database\Factories;

use App\Enums\Language;
use App\Models\Lesson;
use App\Models\User;
use App\Traits\Constants\WithLessonConstants;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    use WithLessonConstants;

    protected $model = Lesson::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'number' => $number = $this->faker->numberBetween(self::MIN_LESSON_COUNT, self::MAX_LESSON_COUNT),
            'total' => $this->faker->numberBetween($number, self::MAX_LESSON_COUNT),
            'language' => $this->faker->randomElement([Language::En->value, Language::Ru->value]),
            'new_chars' => $this->faker->regexify('[a-z]{5}'),
            'text' => $this->faker->sentence(10, true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
