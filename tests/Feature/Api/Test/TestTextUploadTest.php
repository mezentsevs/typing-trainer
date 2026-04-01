<?php

namespace Tests\Feature\Api\Test;

use App\Enums\Language;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\Traits\Fakes\WithFileFakes;

class TestTextUploadTest extends TestTestCase
{
    use WithFileFakes;

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadSuccessHasJsonContentType(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => $language,
                'file' => $this->fakeValidUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadSuccessHasJsonStructure(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => $language,
                'file' => $this->fakeValidUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_UPLOAD_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadWithoutAuthentication(string $language): void
    {
        $response = $this->postJson(self::TEST_UPLOAD_URI, [
            'language' => $language,
            'file' => $this->fakeValidUploadedFile(),
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadWithInvalidToken(string $language): void
    {
        $response = $this->withToken(self::INVALID_TOKEN)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => $language,
                'file' => $this->fakeValidUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testTestTextUploadWithMissingLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'file' => $this->fakeValidUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testTestTextUploadWithEmptyLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => self::INVALID_EMPTY_LANGUAGE,
                'file' => $this->fakeValidUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testTestTextUploadWithUnknownLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => Language::Unknown->value,
                'file' => $this->fakeValidUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    public function testTestTextUploadWithInvalidIntLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => self::INVALID_INT_LANGUAGE,
                'file' => $this->fakeValidUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field must be a string.');
    }

    public function testTestTextUploadWithInvalidSqlInjectionLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => self::INVALID_SQL_INJECTION_LANGUAGE,
                'file' => $this->fakeValidUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadWithMissingFile(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => $language,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'file', 'The file field is required.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadWithNotSupportedFileMimeType(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => $language,
                'file' => $this->fakeInvalidUploadedFileWithNotSupportedFileMimeType(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'file', 'The file field must be a file of type: txt.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadWithExceededFileSize(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => $language,
                'file' => $this->fakeInvalidUploadedFileWithExceededFileSize(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'file', 'The file field must not be greater than 3 kilobytes.');
    }
}
