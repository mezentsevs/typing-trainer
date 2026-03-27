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
                'file' => $this->fakeUploadedFile(),
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
                'file' => $this->fakeUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_UPLOAD_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadWithoutAuthentication(string $language): void
    {
        $response = $this->postJson(self::TEST_UPLOAD_URI, [
            'language' => $language,
            'file' => $this->fakeUploadedFile(),
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
                'file' => $this->fakeUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testTestTextUploadWithMissingLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'file' => $this->fakeUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testTestTextUploadWithEmptyLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => self::INVALID_EMPTY_LANGUAGE,
                'file' => $this->fakeUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testTestTextUploadWithUnknownLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => Language::Unknown->value,
                'file' => $this->fakeUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }

    public function testTestTextUploadWithInvalidIntLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => self::INVALID_INT_LANGUAGE,
                'file' => $this->fakeUploadedFile(),
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field must be a string.');
    }
}
