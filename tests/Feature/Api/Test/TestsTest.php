<?php

namespace Tests\Feature\Api\Test;

use App\Enums\Genre;
use App\Enums\Language;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\Providers\TestDataProvider;

class TestsTest extends TestTestCase
{
    #[DataProviderExternal(TestDataProvider::class, 'provideTestTextRequestData')]
    public function testTestTextRetrieveSuccessHasJsonContentType(array $data): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestTextRequestData')]
    public function testTestTextRetrieveSuccessHasJsonStructure(array $data): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_TEXT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestTextRequestData')]
    public function testTestTextRetrieveWithoutAuthentication(array $data): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestTextRequestData')]
    public function testTestTextRetrieveWithInvalidToken(array $data): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken(self::INVALID_TOKEN)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestTextRetrieveWithUnknownLanguage(string $genre): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, Language::Unknown->value, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestTextRetrieveWithInvalidSqlInjectionLanguage(string $genre): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, self::INVALID_SQL_INJECTION_LANGUAGE, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestTextRetrieveValidationErrorHasJsonContentType(string $genre): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, Language::Unknown->value, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(422, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestTextRetrieveWithMissingLanguage(string $genre): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE_WITH_GENRE_ONLY, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextRetrieveWithMissingGenre(string $language): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE_WITH_LANGUAGE_ONLY, $language);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_TEXT_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestTextRetrieveWithEmptyLanguage(string $genre): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, self::INVALID_EMPTY_LANGUAGE, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextRetrieveWithUnknownGenre(string $language): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, $language, Genre::Unknown->value);

        $response = $this->withToken($this->token)
            ->getJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'genre', 'The selected genre is not supported.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestTextRequestData')]
    public function testTestTextRetrieveWithPostMethod(array $data): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->postJson($testTextUri);

        $route = $this->normalizeUriForMessage(self::TEST_TEXT_URI_BASE);

        $this->withResponse($response)
            ->assertStatusWithMessage(
                405,
                "The POST method is not supported for route {$route}. Supported methods: GET, HEAD.",
            );
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestTextRequestData')]
    public function testTestTextRetrieveMethodNotSupportedHasJsonContentType(array $data): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->postJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(405, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestTextRequestData')]
    public function testTestTextRetrieveMethodNotSupportedHasJsonStructure(array $data): void
    {
        $testTextUri = sprintf(self::TEST_TEXT_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->postJson($testTextUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(405, ['message']);
    }
}
