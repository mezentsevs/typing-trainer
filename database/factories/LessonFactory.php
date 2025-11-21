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

    protected const int TEXT_WORDS_COUNT = 10;
    protected const string NEW_CHARS_REGEX = '[a-zA-Z0-9]{5}';

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
            // TODO: Implement custom new_chars fake method - Faker doesn't work correctly with Cyrillic
            'new_chars' => $this->faker->regexify(self::NEW_CHARS_REGEX),
            'text' => $this->faker->sentence(self::TEXT_WORDS_COUNT, true),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
