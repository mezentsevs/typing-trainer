<?php

namespace Tests\Feature\Api\Lessons;

use App\Enums\Language;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\Traits\WithLesson;

class LessonsShowTest extends LessonTestCase
{
    use WithLesson;

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
    public function testLessonsShowWithoutAuthenticationHasJsonContentType(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(401, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowWithoutAuthenticationHasJsonStructure(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(401, ['message']);
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
    public function testLessonsShowNotFoundHasJsonContentType(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(404, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowNotFoundHasJsonStructure(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->withToken($this->token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(404, ['message']);
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
    public function testLessonsShowMethodNotSupportedHasJsonContentType(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->withToken($this->token)
            ->postJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(405, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testLessonsShowMethodNotSupportedHasJsonStructure(string $language): void
    {
        $lesson = $this->createLesson($this->user, ['language' => $language]);
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $lesson->language, $lesson->number);

        $response = $this->withToken($this->token)
            ->postJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(405, ['message']);
    }
}
