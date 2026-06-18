<?php

namespace Tests\Feature\Api\Test;

use App\Enums\Genre;
use App\Enums\Language;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\Providers\TestDataProvider;

class TestRetrieveTest extends TestTestCase
{
    #[DataProviderExternal(TestDataProvider::class, 'provideTestRetrieveRequestData')]
    public function testTestRetrieveSuccessHasJsonContentType(array $data): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestRetrieveRequestData')]
    public function testTestRetrieveSuccessHasJsonStructure(array $data): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_RETRIEVE_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestRetrieveRequestData')]
    public function testTestRetrieveWithoutAuthentication(array $data): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestRetrieveRequestData')]
    public function testTestRetrieveWithInvalidToken(array $data): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken(self::INVALID_TOKEN)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestRetrieveWithUnknownLanguage(string $genre): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, Language::Unknown->value, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestRetrieveWithInvalidSqlInjectionLanguage(string $genre): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, self::INVALID_SQL_INJECTION_LANGUAGE, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestRetrieveValidationErrorHasJsonContentType(string $genre): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, Language::Unknown->value, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(422, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestRetrieveWithMissingLanguage(string $genre): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE_WITH_GENRE_ONLY, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestRetrieveWithMissingGenre(string $language): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE_WITH_LANGUAGE_ONLY, $language);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_RETRIEVE_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideSupportedGenres')]
    public function testTestRetrieveWithEmptyLanguage(string $genre): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, self::INVALID_EMPTY_LANGUAGE, $genre);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestRetrieveWithUnknownGenre(string $language): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, $language, Genre::Unknown->value);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'genre', 'The selected genre is not supported.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestRetrieveWithInvalidSqlInjectionGenre(string $language): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, $language, self::INVALID_SQL_INJECTION_GENRE);

        $response = $this->withToken($this->token)
            ->getJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'genre', 'The selected genre is not supported.');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestRetrieveRequestData')]
    public function testTestRetrieveWithPostMethod(array $data): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->postJson($testRetrieveUri);

        $route = $this->normalizeUriForMessage(self::TEST_RETRIEVE_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(
                405,
                "The POST method is not supported for route {$route}. Supported methods: GET, HEAD.",
            );
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestRetrieveRequestData')]
    public function testTestRetrieveMethodNotSupportedHasJsonContentType(array $data): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->postJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(405, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(TestDataProvider::class, 'provideTestRetrieveRequestData')]
    public function testTestRetrieveMethodNotSupportedHasJsonStructure(array $data): void
    {
        $testRetrieveUri = sprintf(self::TEST_RETRIEVE_URI_TEMPLATE, $data['language'], $data['genre']);

        $response = $this->withToken($this->token)
            ->postJson($testRetrieveUri);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(405, self::MESSAGE_JSON_STRUCTURE);
    }
}
