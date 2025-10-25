<?php

namespace Tests\Feature\Api\Auth;

use App\Services\LessonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\CommonDataProvider;
use Tests\TestCase;
use Tests\Traits\Assertions\WithAuthAssertions;
use Tests\Traits\Constants\WithLessonConstants;
use Tests\Traits\WithUser;

class LogoutTest extends TestCase
{
    use RefreshDatabase,
        WithUser,
        WithLessonConstants,
        WithAuthAssertions;

    protected LessonService $lessonService;

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
            ->assertLogoutSuccess();
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
            ->assertLogoutSuccess()
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
    public function testAccessLessonAfterLogout(string $language): void
    {
        $user = $this->createUser();
        $token = $this->createTokenForUser($user, self::TOKEN_NAME);
        $this->lessonService->generateLessons($language, self::SINGLE_LESSON_COUNT, $user->id);
        $lessonUri = sprintf(self::LESSONS_SHOW_URI_TEMPLATE, $language, self::LESSON_NUMBER_FOR_ACCESS);

        $response = $this->withToken($token)
            ->postJson(self::LOGOUT_URI);

        $this->withResponse($response)
            ->assertLogoutSuccess();

        $response = $this->withToken($token)
            ->getJson($lessonUri);

        $this->withResponse($response)
            ->assertStatusWithMessage(401, 'Unauthenticated.');
    }
}
