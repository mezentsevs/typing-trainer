<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;
use Tests\Traits\WithUser;

class TestsTest extends TestCase
{
    use RefreshDatabase, WithUser;

    private User $user;

    private string $token;

    private const string TEST_TOKEN_NAME = 'test_token';

    private const int TEST_ERRORS = 2;
    private const int TEST_SPEED_WPM = 50;
    private const int TEST_TIME_SECONDS = 60;
    private const int TEST_ZERO_ERRORS = 0;
    private const int TEST_ZERO_SPEED_WPM = 0;
    private const int TEST_ZERO_TIME_SECONDS = 0;

    private const int TEST_INVALID_ERRORS = -1;
    private const int TEST_INVALID_SPEED_WPM = -1;
    private const int TEST_INVALID_TIME_SECONDS = -1;
    private const string TEST_INVALID_EMPTY_LANGUAGE = '';

    private const int TEST_MAX_FILE_SIZE_KB = 3;
    private const string TEST_FILE_CONTENT = 'Test file content';
    private const string TEST_FILE_NAME = 'test.txt';

    private const int TEST_INVALID_FILE_SIZE_KB = 4;
    private const string TEST_INVALID_FILE_MIME_TYPE = 'image/jpeg';
    private const string TEST_INVALID_FILE_NAME = 'test.jpeg';

    private const string EXPECTED_FILE_UPLOADED_MESSAGE = 'File uploaded';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = $this->createTokenForUser($this->user, self::TEST_TOKEN_NAME);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTextRetrieval(string $language): void
    {
        $response = $this->withToken($this->token)
            ->getJson('/api/test/text?language=' . $language);

        $response->assertStatus(200)
            ->assertJsonStructure(['text']);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTextUpload(string $language): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->createWithContent(
            self::TEST_FILE_NAME,
            self::TEST_FILE_CONTENT,
        );

        $response = $this->withToken($this->token)
            ->postJson('/api/test/upload', [
                'language' => $language,
                'file' => $file,
            ]);

        $response->assertStatus(200)
            ->assertJson(['message' => self::EXPECTED_FILE_UPLOADED_MESSAGE])
            ->assertJsonStructure(['path']);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSaveTestResult(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/test/result', [
                'language' => $language,
                'time_seconds' => self::TEST_TIME_SECONDS,
                'speed_wpm' => self::TEST_SPEED_WPM,
                'errors' => self::TEST_ERRORS,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'user_id',
                'language',
                'speed_wpm',
                'errors',
            ]);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSaveTestResultWithZeroValues(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/test/result', [
                'language' => $language,
                'time_seconds' => self::TEST_ZERO_TIME_SECONDS,
                'speed_wpm' => self::TEST_ZERO_SPEED_WPM,
                'errors' => self::TEST_ZERO_ERRORS,
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'user_id',
                'language',
                'speed_wpm',
                'errors',
            ]);
    }

    public function testTextUploadValidation(): void
    {
        Storage::fake('public');
        $invalidFile = UploadedFile::fake()->create(
            self::TEST_INVALID_FILE_NAME,
            self::TEST_INVALID_FILE_SIZE_KB,
            self::TEST_INVALID_FILE_MIME_TYPE,
        );

        $response = $this->withToken($this->token)
            ->postJson('/api/test/upload', [
                'language' => self::TEST_INVALID_EMPTY_LANGUAGE,
                'file' => $invalidFile,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'language',
                'file',
            ]);
    }

    public function testSaveResultValidationForLanguage(): void
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/test/result', [
                'language' => self::TEST_INVALID_EMPTY_LANGUAGE,
                'time_seconds' => self::TEST_TIME_SECONDS,
                'speed_wpm' => self::TEST_SPEED_WPM,
                'errors' => self::TEST_ERRORS,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['language']);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSaveResultValidationForOtherFields(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/test/result', [
                'language' => $language,
                'time_seconds' => self::TEST_INVALID_TIME_SECONDS,
                'speed_wpm' => self::TEST_INVALID_SPEED_WPM,
                'errors' => self::TEST_INVALID_ERRORS,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'time_seconds',
                'speed_wpm',
                'errors',
            ]);
    }
}
