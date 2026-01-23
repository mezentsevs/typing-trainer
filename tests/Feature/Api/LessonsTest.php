<?php

namespace Tests\Feature\Api;

use App\Enums\Language;
use App\Models\Lesson;
use App\Models\User;
use App\Traits\Constants\WithDatabaseConstants;
use App\Traits\Constants\WithLessonConstants as WithAppLessonConstants;
use App\Traits\Constants\WithStatisticsConstants as WithAppStatisticsConstants;
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
use Tests\Traits\WithUri;
use Tests\Traits\WithUser;

class LessonsTest extends TestCase
{
    use RefreshDatabase,
        WithUser,
        WithLesson,
        WithDatabaseConstants,
        WithTokenConstants,
        WithLanguageConstants,
        WithAppLessonConstants,
        WithLessonConstants,
        WithAppStatisticsConstants,
        WithStatisticsConstants,
        WithResponseAssertions,
        WithUri;

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
    public function testLessonsGenerateWithMinLessonCountSuccess(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::MIN_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Lessons generated')
            ->assertCount(
                self::MIN_LESSON_COUNT,
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
    public function testLessonsGenerateSuccessHasJsonContentType(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::SINGLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, 'Content-Type', 'application/json');
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

    public function testLessonsGenerateValidationErrorHasJsonContentType(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'lesson_count' => self::MULTIPLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(422, 'Content-Type', 'application/json');
    }

    public function testLessonsGenerateWithNullLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => null,
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

    public function testLessonsGenerateWithInvalidIntLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => self::INVALID_INT_LANGUAGE,
                'lesson_count' => self::MULTIPLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field must be a string.');
    }

    public function testLessonsGenerateWithInvalidSqlInjectionLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => self::INVALID_SQL_INJECTION_LANGUAGE,
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
    public function testLessonsGenerateWithNullLessonCount(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => null,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_count', 'The lesson count field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithInvalidBoolLessonCount(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::INVALID_BOOL_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_count', 'The lesson count field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithInvalidStringLessonCount(string $language): void
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
    public function testLessonsGenerateWithInvalidNumericStringLessonCount(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::INVALID_NUMERIC_STRING_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_count', 'The lesson count field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithInvalidFloatLessonCount(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::INVALID_FLOAT_LESSON_COUNT,
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
    public function testLessonsGenerateWithGetMethod(string $language): void
    {
        $response = $this->withToken($this->token)
            ->getJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::MULTIPLE_LESSON_COUNT,
            ]);

        $route = $this->normalizeUriForMessage(self::LESSONS_GENERATE_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(
                405,
                "The GET method is not supported for route {$route}. Supported methods: POST.",
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

    public function testLessonsShowWithUnknownLanguage(): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, Language::Unknown->value, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    public function testLessonsShowValidationErrorHasJsonContentType(): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, Language::Unknown->value, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(422, 'Content-Type', 'application/json');
    }

    public function testLessonsShowWithInvalidSqlInjectionLanguage(): void
    {
        $lessonUri = sprintf(
            self::LESSONS_SHOW_URI_TEMPLATE,
            self::INVALID_SQL_INJECTION_LANGUAGE,
            self::LESSON_NUMBER_FOR_ACCESS,
        );

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowWithMinLessonNumber(string $language): void
    {
        $lesson = $this->createLesson($this->user, [
            'language' => $language,
            'number' => self::MIN_LESSON_COUNT,
        ]);

        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'lesson' => self::LESSONS_SHOW_RESPONSE_LESSON_JSON_STRUCTURE,
            ]);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowWithBelowMinLessonNumber(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::MIN_LESSON_COUNT - 1);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_number', 'The lesson number field must be at least 1.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowWithMaxLessonNumber(string $language): void
    {
        $lesson = $this->createLesson($this->user, [
            'language' => $language,
            'number' => self::MAX_LESSON_COUNT,
            'total' => self::MAX_LESSON_COUNT,
        ]);

        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
                'lesson' => self::LESSONS_SHOW_RESPONSE_LESSON_JSON_STRUCTURE,
            ]);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowSuccessHasJsonContentType(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowWithAboveMaxLessonNumber(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::MAX_LESSON_COUNT + 1);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'lesson_number',
                'The lesson number field must not be greater than 20.',
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowWithPostMethod(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->withToken($this->token)
            ->postJson($lessonUri);

        $route = $this->normalizeUriForMessage($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(
                405,
                "The POST method is not supported for route {$route}. Supported methods: GET, HEAD.",
            );
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
    public function testLessonsResultSaveSuccessHasJsonContentType(string $language): void
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
            ->assertStatusWithHeaderNameAndValue(200, 'Content-Type', 'application/json');
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
    public function testLessonsResultSaveWithNullLessonId(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => null,
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
    public function testLessonsResultSaveWithInvalidBoolLessonId(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => self::INVALID_BOOL_LESSON_ID,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_id', 'The lesson id field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidStringLessonId(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => self::INVALID_STRING_LESSON_ID,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_id', 'The lesson id field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidNumericStringLessonId(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => self::INVALID_NUMERIC_STRING_LESSON_ID,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_id', 'The lesson id field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidFloatLessonId(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => self::INVALID_FLOAT_LESSON_ID,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'lesson_id', 'The lesson id field must be an integer.');
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
    public function testLessonsResultSaveWithNullLanguage(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => null,
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
    public function testLessonsResultSaveWithInvalidSqlInjectionLanguage(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => self::INVALID_SQL_INJECTION_LANGUAGE,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidIntLanguage(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => self::INVALID_INT_LANGUAGE,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field must be a string.');
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
    public function testLessonsResultSaveWithNullTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => null,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidBoolTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::INVALID_BOOL_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidStringTimeSeconds(string $language): void
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
    public function testLessonsResultSaveWithInvalidNumericStringTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::INVALID_NUMERIC_STRING_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidFloatTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::INVALID_FLOAT_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'time_seconds', 'The time seconds field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMinTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::MIN_TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMaxUnsignedIntegerTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::MAX_UNSIGNED_INTEGER,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithAboveMaxUnsignedIntegerTimeSeconds(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::MAX_UNSIGNED_INTEGER + 1,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'time_seconds',
                'The time seconds field must not be greater than ' . self::MAX_UNSIGNED_INTEGER . '.',
            );
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
    public function testLessonsResultSaveWithNullSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => null,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidBoolSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::INVALID_BOOL_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidStringSpeedWpm(string $language): void
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
    public function testLessonsResultSaveWithInvalidNumericStringSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::INVALID_NUMERIC_STRING_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidFloatSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::INVALID_FLOAT_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'speed_wpm', 'The speed wpm field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMinSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::MIN_SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMaxUnsignedIntegerSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::MAX_UNSIGNED_INTEGER,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithAboveMaxUnsignedIntegerSpeedWpm(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::MAX_UNSIGNED_INTEGER + 1,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'speed_wpm',
                'The speed wpm field must not be greater than ' . self::MAX_UNSIGNED_INTEGER . '.',
            );
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
    public function testLessonsResultSaveWithNullErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => null,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidBoolErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::INVALID_BOOL_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidStringErrors(string $language): void
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
    public function testLessonsResultSaveWithInvalidNumericStringErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::INVALID_NUMERIC_STRING_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithInvalidFloatErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::INVALID_FLOAT_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'errors', 'The errors field must be an integer.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMinErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::MIN_ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithMaxUnsignedIntegerErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::MAX_UNSIGNED_INTEGER,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::LESSONS_RESULT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithAboveMaxUnsignedIntegerErrors(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::MAX_UNSIGNED_INTEGER + 1,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(
                422,
                'errors',
                'The errors field must not be greater than ' . self::MAX_UNSIGNED_INTEGER . '.',
            );
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

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsResultSaveWithGetMethod(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);

        $response = $this->withToken($this->token)
            ->getJson(self::LESSONS_RESULT_URI, [
                'lesson_id' => $lesson->id,
                'language' => $lesson->language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $route = $this->normalizeUriForMessage(self::LESSONS_RESULT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(
                405,
                "The GET method is not supported for route {$route}. Supported methods: POST.",
            );
    }
}
