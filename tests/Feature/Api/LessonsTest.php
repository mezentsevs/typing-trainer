<?php

namespace Tests\Feature\Api;

use App\Enums\Language;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Constants\WithLanguageConstants;
use Tests\Traits\Constants\WithLessonConstants;
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
        WithLanguageConstants,
        WithLessonConstants,
        WithStatisticsConstants,
        WithResponseAssertions;

    private string $token;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = $this->createTokenForUser($this->user, self::TOKEN_NAME);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithSingleLessonCountSuccess(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::SINGLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Lessons generated')
            ->assertCount(
                self::SINGLE_LESSON_COUNT,
                Lesson::where('user_id', $this->user->id)
                    ->where('language', $language)
                    ->get(),
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithMultipleLessonCountSuccess(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::MULTIPLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Lessons generated')
            ->assertCount(
                self::MULTIPLE_LESSON_COUNT,
                Lesson::where('user_id', $this->user->id)
                    ->where('language', $language)
                    ->get(),
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithMaxLessonCountSuccess(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::MAX_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Lessons generated')
            ->assertCount(
                self::MAX_LESSON_COUNT,
                Lesson::where('user_id', $this->user->id)
                    ->where('language', $language)
                    ->get(),
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithoutAuthentication(string $language): void
    {
        $response = $this->postJson(self::LESSONS_GENERATE_URI, [
            'language' => $language,
            'lesson_count' => self::MULTIPLE_LESSON_COUNT,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testLessonsGenerateWithMissingLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'lesson_count' => self::MULTIPLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testLessonsGenerateWithEmptyLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => self::INVALID_EMPTY_LANGUAGE,
                'lesson_count' => self::MULTIPLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testLessonsGenerateWithUnknownLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => Language::Unknown->value,
                'lesson_count' => self::MULTIPLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithMissingLessonCount(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_count', 'The lesson count field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithNonIntegerLessonCount(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::INVALID_STRING_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_count', 'The lesson count field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithBelowMinLessonCount(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::MIN_LESSON_COUNT - 1,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'lesson_count',
                'The lesson count field must be at least 1.',
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithAboveMaxLessonCount(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::MAX_LESSON_COUNT + 1,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'lesson_count',
                'The lesson count field must not be greater than 20.',
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowSuccess(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'lesson' => self::LESSONS_SHOW_RESPONSE_LESSON_JSON_STRUCTURE,
            ]);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowExistingWithoutAuthentication(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowNonexistentWithoutAuthentication(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowExistingWithInvalidToken(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->withToken(self::INVALID_TOKEN)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowNonexistentWithInvalidToken(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->withToken(self::INVALID_TOKEN)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowNonexistent(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(404, 'No query results for model [App\\Models\\Lesson].');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowForAnotherUser(string $language): void
    {
        $anotherUser = $this->createUser();
        $lesson = $this->createLesson($anotherUser, ['language' => $language]);
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(404, 'No query results for model [App\\Models\\Lesson].');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveSuccess(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithoutAuthentication(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->postJson(self::LESSONS_RESULT_URI, [
            'lesson_id' => $lesson->id,
            'language' => $lesson->language,
            'time_seconds' => self::TIME_SECONDS,
            'speed_wpm' => self::SPEED_WPM,
            'errors' => self::ERRORS_COUNT,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMissingLessonId(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_id', 'The lesson id field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithNonexistentLessonId(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => self::INVALID_NONEXISTENT_LESSON_ID,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_id', 'The selected lesson id is invalid.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMissingLanguage(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithUnknownLanguage(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => Language::Unknown->value,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMissingTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithNonIntegerTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::INVALID_STRING_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithZeroTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::ZERO_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::INVALID_INT_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be at least 0.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMissingSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithNonIntegerSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::INVALID_STRING_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithZeroSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::ZERO_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::INVALID_INT_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be at least 0.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMissingErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithNonIntegerErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::INVALID_STRING_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithZeroErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ZERO_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::INVALID_INT_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be at least 0.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveForAnotherUser(string $language): void
    {
        $anotherUser = $this->createUser();
        $lesson = $this->createLesson($anotherUser, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(403, 'This action is unauthorized.');
    }
}
