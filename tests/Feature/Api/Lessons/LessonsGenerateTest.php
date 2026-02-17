<?php

namespace Tests\Feature\Api\Lessons;

use App\Enums\Language;
use App\Models\Lesson;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;

class LessonsGenerateTest extends LessonTestCase
{
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
    public function testLessonsGenerateSuccessHasJsonStructure(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::SINGLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructureAndJson(200, ['message'], ['message' => 'Lessons generated']);
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

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithoutAuthenticationHasJsonContentType(string $language): void
    {
        $response = $this->postJson(self::LESSONS_GENERATE_URI, [
            'language' => $language,
            'lesson_count' => self::MULTIPLE_LESSON_COUNT,
        ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(401, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateWithoutAuthenticationHasJsonStructure(string $language): void
    {
        $response = $this->postJson(self::LESSONS_GENERATE_URI, [
            'language' => $language,
            'lesson_count' => self::MULTIPLE_LESSON_COUNT,
        ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(401, ['message']);
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
    public function testLessonsGenerateMethodNotSupportedHasJsonContentType(string $language): void
    {
        $response = $this->withToken($this->token)
            ->getJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::MULTIPLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(405, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsGenerateMethodNotSupportedHasJsonStructure(string $language): void
    {
        $response = $this->withToken($this->token)
            ->getJson(self::LESSONS_GENERATE_URI, [
                'language' => $language,
                'lesson_count' => self::MULTIPLE_LESSON_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(405, ['message']);
    }
}
