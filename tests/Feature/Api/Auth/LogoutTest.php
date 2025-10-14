<?php

namespace Tests\Feature\Api\Auth;

use App\Services\LessonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;
use Tests\Traits\Assertions\WithResponseAssertions;
use Tests\Traits\Constants\WithAuthConstants;
use Tests\Traits\WithUser;

class LogoutTest extends TestCase
{
    use RefreshDatabase, WithUser, WithResponseAssertions, WithAuthConstants;

    protected LessonService $lessonService;

    private const int LESSON_COUNT_FOR_ACCESS = 1;
    private const int LESSON_NUMBER_FOR_ACCESS = 1;
    private const string LESSONS_URI_TEMPLATE = '/api/lessons/%s/%d';

    protected function setUp(): void
    {
        parent::setUp();
        $this->lessonService = app(LessonService::class);
    }

    public function testLogoutSuccess(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Logged out');
    }

    public function testLogoutReturnsCorrectHttpHeaders(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithHeaderNameAndValue(200, self::CONTENT_TYPE_HEADER_NAME, self::JSON_MIME_TYPE);
    }

    public function testLogoutWithoutAuthentication(): void
    {
        $response = $this->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testLogoutMustInvalidateAllTokens(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);
        $this->createTokenForUser($user, self::ANOTHER_TOKEN_NAME);
        $expectedTokensCount = 2;

        $this->assertEquals(
            $expectedTokensCount,
            $user->tokens()->count(),
            "User should have {$expectedTokensCount} tokens before logout.",
        );

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Logged out')
            ->assertEquals(0, $user->tokens()->count(), 'User should have no tokens after logout.');
    }

    public function testLogoutWithInvalidToken(): void
    {
        $response = $this->withToken(self::INVALID_TOKEN)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testLogoutWithInvalidTokenFormat(): void
    {
        $response = $this->withHeader(self::AUTHORIZATION_HEADER_NAME, self::INVALID_TOKEN)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testLogoutWithoutTokenHeader(): void
    {
        $response = $this->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testLogoutWithExpiredToken(): void
    {
        $user = $this->createUser();
        $token = $user->createToken(
            self::TOKEN_NAME,
            [self::DEFAULT_TOKEN_ABILITY],
            now()->subDay(),
        )->plainTextToken;

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    public function testLogoutWithDeletedUser(): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);
        $user->delete();

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testAccessLessonWithoutAuthentication(string $language): void
    {
        $lessonUri = sprintf(self::LESSONS_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }

    #[DataProviderExternal(CommonDataProvider::class, 'provideSupportedLanguages')]
    public function testAccessLessonAfterLogout(string $language): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);
        $this->lessonService->generateLessons($language, self::LESSON_COUNT_FOR_ACCESS, $user->id);
        $lessonUri = sprintf(self::LESSONS_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertStatusWithMessage(200, 'Logged out');

        $response = $this->withToken($token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }
}
