<?php

namespace Tests\Feature\Api\Test;

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
}
