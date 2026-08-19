<?php

namespace Database\Factories;

use App\Languages\Registry\LanguageRegistry;
use App\Models\Lesson;
use App\Models\LessonResult;
use App\Models\User;
use App\Traits\Constants\WithDatabaseConstants;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LessonResult>
 */
class LessonResultFactory extends Factory
{
    use WithDatabaseConstants;

    protected $model = LessonResult::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'lesson_id' => Lesson::factory(),
            'language' => $this->faker->randomElement(app(LanguageRegistry::class)->getSupportedCodes()),
            'time_seconds' => $this->faker->numberBetween(0, self::MAX_UNSIGNED_INTEGER),
            'speed_wpm' => $this->faker->numberBetween(0, self::MAX_UNSIGNED_INTEGER),
            'errors' => $this->faker->numberBetween(0, self::MAX_UNSIGNED_INTEGER),
            'success' => $this->faker->boolean(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
