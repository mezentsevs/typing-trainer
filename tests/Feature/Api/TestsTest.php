<?php

namespace Tests\Feature\Api;

use App\Enums\Language;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Traits\WithUser;
use Tests\TestCase;

class TestsTest extends TestCase
{
    use RefreshDatabase, WithUser;

    private const int TEST_ERRORS = 2;
    private const int TEST_EXCEEDED_FILE_SIZE = 4;
    private const int TEST_INVALID_ERRORS = -1;
    private const int TEST_INVALID_SPEED_WPM = -1;
    private const int TEST_INVALID_TIME_SECONDS = -1;
    private const int TEST_MAX_FILE_SIZE = 3;
    private const int TEST_SPEED_WPM = 50;
    private const int TEST_TIME_SECONDS = 60;
    private const int TEST_ZERO_ERRORS = 0;
    private const int TEST_ZERO_SPEED_WPM = 0;
    private const int TEST_ZERO_TIME_SECONDS = 0;
    private const string TEST_EMPTY_LANGUAGE = '';
    private const string TEST_FILE_CONTENT = 'Test file content';
    private const string TEST_INVALID_FILE_TYPE = 'image/jpeg';
    private const string TEST_TOKEN_NAME = 'test_token';

    private const string EXPECTED_FILE_UPLOADED_MESSAGE = 'File uploaded';

    public function testTextRetrieval(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);

        $response = $this->withToken($token)
            ->getJson('/api/test/text?language=en');

        $response->assertStatus(200)
            ->assertJsonStructure(['text']);
    }

    public function testTextUpload(): void
    {
        Storage::fake('public');
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);
        $file = UploadedFile::fake()->createWithContent('test.txt', self::TEST_FILE_CONTENT);

        $response = $this->withToken($token)
            ->postJson('/api/test/upload', [
                'language' => Language::En->value,
                'file' => $file,
            ]);

        $response->assertStatus(200)
            ->assertJson(['message' => self::EXPECTED_FILE_UPLOADED_MESSAGE])
            ->assertJsonStructure(['path']);
    }

    public function testSaveTestResult(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson('/api/test/result', [
                'language' => Language::En->value,
                'time_seconds' => self::TEST_TIME_SECONDS,
                'speed_wpm' => self::TEST_SPEED_WPM,
                'errors' => self::TEST_ERRORS,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'user_id', 'language', 'speed_wpm', 'errors']);
    }

    public function testSaveTestResultWithZeroValues(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson('/api/test/result', [
                'language' => Language::En->value,
                'time_seconds' => self::TEST_ZERO_TIME_SECONDS,
                'speed_wpm' => self::TEST_ZERO_SPEED_WPM,
                'errors' => self::TEST_ZERO_ERRORS,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'user_id', 'language', 'speed_wpm', 'errors']);
    }

    public function testTextUploadValidation(): void
    {
        Storage::fake('public');
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);
        $invalidFile = UploadedFile::fake()->create('test.jpg', self::TEST_EXCEEDED_FILE_SIZE, self::TEST_INVALID_FILE_TYPE);

        $response = $this->withToken($token)
            ->postJson('/api/test/upload', [
                'language' => self::TEST_EMPTY_LANGUAGE,
                'file' => $invalidFile,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['language', 'file']);
    }

    public function testSaveResultValidationForLanguage(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson('/api/test/result', [
                'language' => self::TEST_EMPTY_LANGUAGE,
                'time_seconds' => self::TEST_TIME_SECONDS,
                'speed_wpm' => self::TEST_SPEED_WPM,
                'errors' => self::TEST_ERRORS,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['language']);
    }

    public function testSaveResultValidationForOtherFields(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TEST_TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson('/api/test/result', [
                'language' => Language::En->value,
                'time_seconds' => self::TEST_INVALID_TIME_SECONDS,
                'speed_wpm' => self::TEST_INVALID_SPEED_WPM,
                'errors' => self::TEST_INVALID_ERRORS,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['time_seconds', 'speed_wpm', 'errors']);
    }
}
