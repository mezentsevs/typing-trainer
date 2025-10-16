<?php

namespace Tests\Feature\Api;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Constants\WithStatisticsConstants;
use Tests\Traits\Constants\WithTokenConstants;
use Tests\Traits\WithLesson;
use Tests\Traits\WithUser;

class LessonsTest extends TestCase
{
    use RefreshDatabase,
        WithUser,
        WithLesson,
        WithTokenConstants,
        WithStatisticsConstants,
        WithResponseAssertions;

    private User $user;

    private string $token;

    private const int LESSON_COUNT = 5;

    private const int INVALID_LESSON_COUNT = 0;
    private const int INVALID_LESSON_NUMBER = 999;

    private const string EXPECTED_LESSONS_GENERATED_MESSAGE = 'Lessons generated';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = $this->createTokenForUser($this->user, self::TOKEN_NAME);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonGeneration(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/lessons/generate', [
                'language' => $language,
                'lesson_count' => self::LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, self::EXPECTED_LESSONS_GENERATED_MESSAGE);

        $this->assertCount(
            self::LESSON_COUNT,
            Lesson::where('user_id', $this->user->id)
                ->where('language', $language)
                ->get(),
        );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonShow(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->getJson("/api/lessons/{$lesson->language}/{$lesson->number}");

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, ['lesson']);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSaveLessonResult(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson('/api/lessons/result', [
                'lesson_id' => $lesson->id,
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'id',
                'user_id',
                'lesson_id',
                'language',
                'speed_wpm',
                'errors',
            ]);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSaveLessonResultWithZeroValues(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson('/api/lessons/result', [
                'lesson_id' => $lesson->id,
                'language' => $language,
                'time_seconds' => self::ZERO_TIME_SECONDS,
                'speed_wpm' => self::ZERO_SPEED_WPM,
                'errors' => self::ZERO_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'id',
                'user_id',
                'lesson_id',
                'language',
                'speed_wpm',
                'errors',
            ]);
    }

    public function testLessonGenerationValidation(): void
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/lessons/generate', [
                'language' => self::INVALID_EMPTY_LANGUAGE,
                'lesson_count' => self::INVALID_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonValidationErrors(422, [
                'language',
                'lesson_count',
            ]);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSaveLessonResultValidation(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson('/api/lessons/result', [
                'lesson_id' => $lesson->id,
                'language' => $language,
                'time_seconds' => self::INVALID_TIME_SECONDS,
                'speed_wpm' => self::INVALID_SPEED_WPM,
                'errors' => self::INVALID_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonValidationErrors(422, [
                'time_seconds',
                'speed_wpm',
                'errors',
            ]);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonNotFound(string $language): void
    {
        $response = $this->withToken($this->token)
            ->getJson('/api/lessons/' . $language . '/' . self::INVALID_LESSON_NUMBER);

        $response->assertStatus(404);
    }
}
