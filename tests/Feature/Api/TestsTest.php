<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\WithUser;

class TestsTest extends TestCase
{
    use RefreshDatabase, WithUser, WithResponseAssertions;

    private User $user;

    private string $token;

    private const string TOKEN_NAME = 'testToken';

    private const int ERRORS_COUNT = 2;
    private const int MAX_FILE_SIZE_KB = 3;
    private const int SPEED_WPM = 50;
    private const int TIME_SECONDS = 60;
    private const int ZERO_ERRORS_COUNT = 0;
    private const int ZERO_SPEED_WPM = 0;
    private const int ZERO_TIME_SECONDS = 0;
    private const string FILE_CONTENT = 'Test file content';
    private const string FILE_NAME = 'test.txt';

    private const int INVALID_ERRORS_COUNT = -1;
    private const int INVALID_FILE_SIZE_KB = 4;
    private const int INVALID_SPEED_WPM = -1;
    private const int INVALID_TIME_SECONDS = -1;
    private const string INVALID_EMPTY_LANGUAGE = '';
    private const string INVALID_FILE_MIME_TYPE = 'image/jpeg';
    private const string INVALID_FILE_NAME = 'test.jpeg';

    private const string EXPECTED_FILE_UPLOADED_MESSAGE = 'File uploaded';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->token = $this->createTokenForUser($this->user, self::TOKEN_NAME);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTextRetrieval(string $language): void
    {
        $response = $this->withToken($this->token)
            ->getJson('/api/test/text?language=' . $language);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, ['text']);
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testTextUpload(string $language): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->createWithContent(
            self::FILE_NAME,
            self::FILE_CONTENT,
        );

        $response = $this->withToken($this->token)
            ->postJson('/api/test/upload', [
                'language' => $language,
                'file' => $file,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructureAndJson(
                200,
                ['path'],
                ['message' => self::EXPECTED_FILE_UPLOADED_MESSAGE],
            );
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testSaveTestResult(string $language): void
    {
        $response = $this->withToken($this->token)
            ->postJson('/api/test/result', [
                'language' => $language,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
            ]);

        $this->withResponse($response)
            ->assertStatusWithJsonStructure(200, [
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
                'time_seconds' => self::ZERO_TIME_SECONDS,
                'speed_wpm' => self::ZERO_SPEED_WPM,
                'errors' => self::ZERO_ERRORS_COUNT,
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
            self::INVALID_FILE_NAME,
            self::INVALID_FILE_SIZE_KB,
            self::INVALID_FILE_MIME_TYPE,
        );

        $response = $this->withToken($this->token)
            ->postJson('/api/test/upload', [
                'language' => self::INVALID_EMPTY_LANGUAGE,
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
                'language' => self::INVALID_EMPTY_LANGUAGE,
                'time_seconds' => self::TIME_SECONDS,
                'speed_wpm' => self::SPEED_WPM,
                'errors' => self::ERRORS_COUNT,
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
                'time_seconds' => self::INVALID_TIME_SECONDS,
                'speed_wpm' => self::INVALID_SPEED_WPM,
                'errors' => self::INVALID_ERRORS_COUNT,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'time_seconds',
                'speed_wpm',
                'errors',
            ]);
    }
}
