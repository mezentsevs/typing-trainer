<?php

namespace Tests\Feature\Api\Test;

use App\Enums\Language;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;

class TestTextUploadTest extends TestTestCase
{
    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadSuccessHasJsonContentType(string $language): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );

        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => $language,
                'file' => $file,
            ]);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, 'Content-Type', 'application/json');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadSuccessHasJsonStructure(string $language): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );

        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => $language,
                'file' => $file,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, self::TEST_UPLOAD_RESPONSE_JSON_STRUCTURE);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadWithoutAuthentication(string $language): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );

        $response = $this->postJson(self::TEST_UPLOAD_URI, [
            'language' => $language,
            'file' => $file,
        ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTestTextUploadWithInvalidToken(string $language): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );

        $response = $this->withToken(self::INVALID_TOKEN)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => $language,
                'file' => $file,
            ]);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testTestTextUploadWithMissingLanguage(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );

        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'file' => $file,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testTestTextUploadWithEmptyLanguage(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );

        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => self::INVALID_EMPTY_LANGUAGE,
                'file' => $file,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The language field is required.');
    }

    public function testTestTextUploadWithUnknownLanguage(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );

        $response = $this->withToken($this->token)
            ->postJson(self::TEST_UPLOAD_URI, [
                'language' => Language::Unknown->value,
                'file' => $file,
            ]);

        $this->withResponse($response)
            ->assertStatusWithErrorAndMessage(422, 'language', 'The selected language is not supported.');
    }
}
